<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use DB;
use App\JournalEntry;
use App\JournalEntryBreakdown;
use App\Account;
use App\Report;
use App\Graph;
use App\AccountingAccount;
class JournalController extends Controller
{
  public function save_configuration() {
    $validator = Validator::make(Input::all(),
      array(
        'retained_vat' => 'required',
        'advanced_vat' => 'required',
        'retained_it' => 'required',
        'advanced_it' => 'required',
        'isc' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $accounting_accounts = AccountingAccount::where('id', 1)->first();

    $account_check = Account::where('code', Input::get('retained_vat'))->first();
    if(!$account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_code_not_found').Input::get('retained_vat')
      );
      return response()->json($response);
    }
    if($account_check->type != 'li') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_not_liability').Input::get('retained_vat')
      );
      return response()->json($response);
    }

    $account_check = Account::where('code', Input::get('advanced_vat'))->first();
    if(!$account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_code_not_found').Input::get('advanced_vat')
      );
      return response()->json($response);
    }
    if($account_check->type != 'as') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_not_asset').Input::get('advanced_vat')
      );
      return response()->json($response);
    }

    $account_check = Account::where('code', Input::get('retained_it'))->first();
    if(!$account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_code_not_found').Input::get('retained_it')
      );
      return response()->json($response);
    }
    if($account_check->type != 'li') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_not_liability').Input::get('retained_it')
      );
      return response()->json($response);
    }

    $account_check = Account::where('code', Input::get('advanced_it'))->first();
    if(!$account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_code_not_found').Input::get('advanced_it')
      );
      return response()->json($response);
    }
    if($account_check->type != 'as') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.account_not_asset').Input::get('advanced_it')
      );
      return response()->json($response);
    }

    $accounting_accounts->retained_VAT_account = Input::get('retained_vat');
    $accounting_accounts->advanced_VAT_account = Input::get('advanced_vat');
    if(Input::get('entity_type') == 'legal') {
      $accounting_accounts->VAT_percentage = Input::get('vat_percentage');
    }
    if(Input::get('entity_type') == 'natural') {
      $accounting_accounts->fixed_fee = Input::get('fixed_fee');
    }
    $accounting_accounts->retained_IT_account = Input::get('retained_it');
    $accounting_accounts->advanced_IT_account = Input::get('advanced_it');
    if(Input::get('entity_type') == 'legal') {
      $accounting_accounts->IT_percentage = Input::get('it_percentage');
    }
    if(Input::get('entity_type') == 'natural') {
      $accounting_accounts->IT_rules = json_encode(Input::get('it_rules'));
    }
    $accounting_accounts->ISC_account = Input::get('isc');
    $accounting_accounts->entity_type = Input::get('entity_type');

    $accounting_accounts->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/journal_controller.accounting_accounts_updated')
    );
    return response()->json($response);
  }

  private function convert_account_type($type) {
    switch($type) {
      case 'activo':
        return 'as';
        break;
      case 'gasto':
        return 'dr';
        break;
      case 'costo':
        return 'ex';
        break;
      case 'pasivo':
        return 'li';
        break;
      case 'patrimonio':
        return 'eq';
        break;
      case 'ingresos':
        return 're';
        break;
    }
  }

  private function get_graph_labels($period, $group_by) {
    $results = array();

    switch($group_by) {
      case 'day':
        $current = date('Y-m-d', strtotime($period[0]));
        while($current <= date('Y-m-d', strtotime($period[1]))) {
          array_push($results, $current);
          $current = date('Y-m-d', strtotime($current.' +1 day'));
        }
        break;
      case 'week':
        $current = date('o-W', strtotime($period[0]));
        $current_timonthtamp = date('Y-m-d', strtotime($period[0]));
        while($current <= date('o-W', strtotime($period[1]))) {
          array_push($results, $current);
          $current_timonthtamp = date('Y-m-d', strtotime($current_timonthtamp.' +1 week'));
          $current = date('o-W', strtotime($current_timonthtamp));
        }
        break;
      case 'month':
        $current = date('Y-m', strtotime($period[0]));
        while($current <= date('Y-m', strtotime($period[1]))) {
          array_push($results, $current);
          $current = date('Y-m', strtotime($current.' +1 month'));
        }
        break;
      case 'year':
        $current = date('Y', strtotime($period[0]));
        while($current <= date('Y', strtotime($period[1]))) {
          array_push($results, $current);
          $current = date('Y', strtotime($current.' +1 year'));
        }
        break;
    }
    return $results;
  }

  private function get_results_period($period, $group_by) {
    $results = array();

    switch($group_by) {
      case 'summary':
        array_push($results, array(
          'total' => 0
        ));
        break;
      case 'day':
        $current = date('Y-m-d', strtotime($period[0]));
        while($current <= date('Y-m-d', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-m-d', strtotime($current.' +1 day'));
        }
        break;
      case 'week':
        $current = date('o-W', strtotime($period[0]));
        $current_timonthtamp = date('Y-m-d', strtotime($period[0]));
        while($current <= date('o-W', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current_timonthtamp = date('Y-m-d', strtotime($current_timonthtamp.' +1 week'));
          $current = date('o-W', strtotime($current_timonthtamp));
        }
        break;
      case 'month':
        $current = date('Y-m', strtotime($period[0]));
        while($current <= date('Y-m', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-m', strtotime($current.' +1 month'));
        }
        break;
      case 'year':
        $current = date('Y', strtotime($period[0]));
        while($current <= date('Y', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y', strtotime($current.' +1 year'));
        }
        break;
    }
    return $results;
  }

  private function get_accounts($data) {
    $accounts = array();
    array_push($accounts, $data['codigo']);
    if($data['sub'] == 1) {
      $children = \App\Account::where('parent_account', $data['codigo'])->get();
      foreach($children as $child) {
        if($child->has_children) {
          $child_accounts = get_accounts(array(
            'codigo' => $child->code,
            'sub' => 1
          ));
          foreach($child_accounts as $child_account) {
            array_push($accounts, $child_account->code);
          }
        } else {
          array_push($accounts, $child->code);
        }
      }
    }
    return $accounts;
  }

  private function get_account_type($code) {
    $account = \App\Account::where('code', $code)->first();
    return $account->type;
  }

  private function calculate_variation($entries, $data, $group_by, $period) {
    $data = json_decode($data, true);

    $accounts = array();
    $results = $this->get_results_period($period, $group_by);


    if(array_key_exists('tipo', $data)) {
      $type = $this->convert_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type as $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_by) {
          case 'summary':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[0]['total'] += $entry->amount;
                } else {
                  $results[0]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[0]['total'] -= $entry->amount;
                } else {
                  $results[0]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'day':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'week':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'month':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'year':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
        }
      }
    } else {
      $accounts = $this->get_accounts($data);
      $type = $this->get_account_type($data['codigo']);
      foreach($entries as $entry) {
        switch($group_by) {
          case 'summary':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[0]['total'] += $entry->amount;
                } else {
                  $results[0]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[0]['total'] -= $entry->amount;
                } else {
                  $results[0]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'day':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'week':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('o-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'month':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'year':
            if(in_array($entry->account_code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
        }
      }
    }
    return $results;
  }

  private function calculate_debit($entries, $data, $group_by, $period) {
    $data = json_decode($data, true);

    $accounts = array();
    $results = $this->get_results_period($period, $group_by);



    if(array_key_exists('tipo', $data)) {
      $type = $this->convert_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type as $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_by) {
          case 'summary':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'day':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'week':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'month':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'year':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    } else {
      $accounts = $this->get_accounts($data);
      $type = $this->get_account_type($data['codigo']);
      foreach($entries as $entry) {
        switch($group_by) {
          case 'summary':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'day':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'week':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'month':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'year':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    }
    return $results;
  }

  private function calculate_credit($entries, $data, $group_by, $period) {
    $data = json_decode($data, true);

    $accounts = array();
    $results = $this->get_results_period($period, $group_by);



    if(array_key_exists('tipo', $data)) {
      $type = $this->convert_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type as $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_by) {
          case 'summary':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'day':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'week':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'month':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'year':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    } else {
      $accounts = $this->get_accounts($data);
      $type = $this->get_account_type($data['codigo']);
      foreach($entries as $entry) {
        switch($group_by) {
          case 'summary':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'day':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'week':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'month':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'year':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    }
    return $results;
  }

  private function make_calculation($operations, $calculations, $period, $group_by) {
    $results = $this->get_results_period($period, $group_by);

    foreach($results as $key => $result) {
      $results[$key]['total'] += $calculations[0][$key]['total'];
      $count = 1;
      foreach($operations as $operation) {
        switch($operation) {
          case '+':
            $results[$key]['total'] += $calculations[$count][$key]['total'];
            break;
          case '-':
            $results[$key]['total'] -= $calculations[$count][$key]['total'];
            break;
          case '*':
            $results[$key]['total'] *= $calculations[$count][$key]['total'];
            break;
          case '/':
            $results[$key]['total'] /= $calculations[$count][$key]['total'];
            break;
        }
        $count++;
      }
    }
    return $results;
  }

  private function calculate_variable($reports, $group_by, $period, $name, $data, $entries, &$variables) {
    $operations = array();
    $calculations = array();
    foreach($data['calc'] as $index => $calc) {

      // Check if this index is dividable by 2 to know if it's a operation symbol.
      if(($index % 2) == 0) {
        // Extract the calculation data.
        $entry_parts = preg_split('/(\(|\))/', $calc);

        // If it's a variable make sure it's calculated.
        if($entry_parts[0] == 'variable') {
          if(!array_key_exists($entry_parts[1], $variables)) {
            $variables[$entry_parts[1]] = $this->calculate_variable($reports, $period, $entry_parts[1], $reports['variables'][$entry_parts[1]], $entries, $variables);
            array_push($calculations, $variables[$entry_parts[1]]);
          } else {
            array_push($calculations, $variables[$entry_parts[1]]);
          }
        } else {
          // If it's not a variable make the calculation.
          switch($entry_parts[0]) {
            case 'variacion':
              array_push($calculations, $this->calculate_variation($entries, $entry_parts[1], $group_by, $period));
              break;
            case 'credito':
              array_push($calculations, $this->calculate_credit($entries, $entry_parts[1], $group_by, $period));
              break;
            case 'debito':
              array_push($calculations, $this->calculate_debit($entries, $entry_parts[1], $group_by, $period));
              break;
            case 'balance':
              array_push($calculations, $this->calculate_balance($entries, $entry_parts[1], $group_by, $period));
              break;
            default:
              array_push($calculations, $calc);
              break;
          }
        }
      } else {
        array_push($operations, $calc);
      }
    }
    // Finally make the calculation.
    return $this->make_calculation($operations, $calculations, $period, $group_by);
  }

  public function download_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report_data' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $report_data = json_decode(Input::get('report_data'), true);

    $report = Report::where('id', $report_data['report'])->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = $report_data['date_range'];
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    $report->layout = json_decode($report->layout);
    $report->variables = json_decode($report->variables);

    // Calculate all required variables for report.
    $entries = DB::table('journal_entries')
      //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
      ->join('journal_entries_breakdown', function($join) {
        $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
        $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
      })
      ->select('journal_entries.*', 'journal_entries_breakdown.*')
      ->whereBetween('journal_entries.entry_date', $date_range)
      ->orderBy('journal_entries.entry_date')
      ->get();

    $variables = array();


    $report = json_decode(json_encode($report), true);
    foreach($report['variables'] as $name => $data) {
      // Make sure we haven't already calculated this variable.
      if(!array_key_exists($name, $variables)) {
        $variables[$name] = $this->calculate_variable($report, $report['group_by'], $date_range, $name, $data, $entries, $variables);
      }
    }

    $row = 0;
    $col = 0;
    $max_row = 0;
    $layout = array();
    foreach($report['layout'] as $index => $data) {
      foreach($data['columns'] as $i => $column) {
        if(is_array($column)) {
          $current_row = $row;
          foreach($column as $sub_i => $sub_column) {
            $entry_parts = preg_split('/(\(|\))/', $sub_column);
            if($entry_parts[0] == 'variable') {
              $count = 0;
              foreach($variables[$entry_parts[1]] as $key => $result) {
                for($i = 0; $i < $col; $i++) {
                  if(!isset($layout[$current_row][$i])){
                    $layout[$current_row][$i] = "";
                  }
                }
                if($key == 'total') {
                  $layout[$current_row][$col] = $result['total'];
                  $current_row++;
                  if($current_row > $max_row) {
                    $max_row = $current_row;
                  }
                } else {
                  $layout[$current_row][$col] = $key;
                  $col++;
                  $layout[$current_row][$col] = $result['total'];
                  if(count($variables[$entry_parts[1]]) > 1) {
                    $current_row++;
                    if($current_row > $max_row) {
                      $max_row = $current_row;
                    }
                  }
                }
                $count++;
                if($count != count($variables[$entry_parts[1]])) {
                  $col = $i;
                }
              }
            } else {
              for($i = 0; $i < $col; $i++) {
                if(!isset($layout[$current_row][$i])){
                  $layout[$current_row][$i] = "";
                }
              }
              $layout[$current_row][$col] = strip_tags($sub_column);
              $current_row++;
              if($current_row > $max_row) {
                $max_row = $current_row;
              }
            }
          }
        } else {
          $current_row = $row;
          $entry_parts = preg_split('/(\(|\))/', $column);
          if($entry_parts[0] == 'variable') {
            $count = 0;
            foreach($variables[$entry_parts[1]] as $key => $result) {
              for($i = 0; $i < $col; $i++) {
                if(!isset($layout[$current_row][$i])){
                  $layout[$current_row][$i] = "";
                }
              }
              if($key == 'total') {
                $layout[$current_row][$col] = $result['total'];
              } else {
                $layout[$current_row][$col] = $key;
                $col++;
                $layout[$current_row][$col] = $result['total'];
              }
              if(count($variables[$entry_parts[1]]) > 1) {
                $current_row++;
                if($current_row > $max_row) {
                  $max_row = $current_row;
                }
              }
              $count++;
              if($count != count($variables[$entry_parts[1]])) {
                $col = $i;
              }
            }
          } else {
            $layout[$current_row][$col] = strip_tags($column);
            $current_row++;
            if($current_row > $max_row) {
              $max_row = $current_row;
            }
          }
        }
        $col++;
      }
      $row = $max_row;
      $row++;
      $col = 0;
    }

    // Prepare headers.
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".$report['name'].".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $callback = function() use ($layout, $report, $date_range) {
      $file = fopen('php://output', 'w');

      foreach($layout as $row => $content) {
        fputcsv($file, $content);
      }
      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }

  public function print_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
        'date_range' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = Input::get('date_range');
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    $report->layout = json_decode($report->layout);
    $report->variables = json_decode($report->variables);

    // Return view.
    return view('system.printables.accounting.report',
     [
       'report' => $report,
       'group_by' => $report->group_by,
       'date_range' => $date_range,
    ]);
  }

  private function rgba($rgb, $a) {
    return 'rgba('.$rgb->r.','.$rgb->g.','.$rgb->b.','.$a.')';
  }

  public function generate_graph() {
    $validator = Validator::make(Input::all(),
      array(
        'graph' => 'required',
        'date_range' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $graph = Graph::where('id', Input::get('graph'))->first();

    if(!$graph) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.graph_not_found')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = Input::get('date_range');
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    $graph->variables = json_decode($graph->variables);

    // Calculate all required variables for report.
    $entries = DB::table('journal_entries')
      //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
      ->join('journal_entries_breakdown', function($join) {
        $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
        $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
      })
      ->select('journal_entries.*', 'journal_entries_breakdown.*')
      ->whereBetween('journal_entries.entry_date', $date_range)
      ->orderBy('journal_entries.entry_date')
      ->get();

    $variables = array();

    $graph = json_decode(json_encode($graph), true);
    foreach($graph['variables'] as $name => $data) {
      // Make sure we haven't already calculated this variable.
      if(!array_key_exists($name, $variables)) {
        $variables[$name] = $this->calculate_variable($graph, $graph['group_by'], $date_range, $name, $data, $entries, $variables);
      }
    }

    switch($graph['graph_type']) {
      case 'line':
        $graph_setup = array(
          'type' => 'line',
          'data' => array(
            'labels' => $this->get_graph_labels($date_range, $graph['group_by']),
            'datasets' => array()
          )
        );
        $graph['graphed_variables'] = json_decode($graph['graphed_variables']);
        $graph['colors'] = json_decode($graph['colors']);
        foreach($graph['graphed_variables'] as $key => $data) {
          $graph_data = array();
          foreach($graph_setup['data']['labels'] as $index => $date) {
            array_push($graph_data, $variables[$data][$date]['total']);
          }
          array_push($graph_setup['data']['datasets'], array(
            'label' => $data,
            'data' => $graph_data,
            'backgroundColor' => $this->rgba($graph['colors']->$data, '0.2'),
            'borderColor' => $this->rgba($graph['colors']->$data, '1'),
            'borderWidth' => 1,
          ));
        }
        break;
      case 'bar':

        if($graph['group_by'] == 'summary') {
          $graph['graphed_variables'] = json_decode($graph['graphed_variables']);
          $graph_setup = array(
            'type' => 'bar',
            'data' => array(
              'labels' => $graph['graphed_variables'],
              'datasets' => array()
            )
          );
          $graph['colors'] = json_decode($graph['colors']);
          foreach($graph['graphed_variables'] as $key => $data) {
            $graph_data = array();
            array_push($graph_data, $variables[$data][0]['total']);
            array_push($graph_setup['data']['datasets'], array(
              'label' => $data,
              'data' => $graph_data,
              'backgroundColor' => $this->rgba($graph['colors']->$data, '0.2'),
              'borderColor' => $this->rgba($graph['colors']->$data, '1'),
              'borderWidth' => 1,
            ));
          }
        } else {
          $graph_setup = array(
            'type' => 'bar',
            'data' => array(
              'labels' => $this->get_graph_labels($date_range, $graph['group_by']),
              'datasets' => array()
            )
          );
          $graph['graphed_variables'] = json_decode($graph['graphed_variables']);
          $graph['colors'] = json_decode($graph['colors']);
          foreach($graph['graphed_variables'] as $key => $data) {
            $graph_data = array();
            foreach($graph_setup['data']['labels'] as $index => $date) {
              array_push($graph_data, $variables[$data][$date]['total']);
            }
            array_push($graph_setup['data']['datasets'], array(
              'label' => $data,
              'data' => $graph_data,
              'backgroundColor' => $this->rgba($graph['colors']->$data, '0.2'),
              'borderColor' => $this->rgba($graph['colors']->$data, '1'),
              'borderWidth' => 1,
            ));
          }
        }
        break;
      case 'pie':
        $graph['graphed_variables'] = json_decode($graph['graphed_variables']);
        $graph_setup = array(
          'type' => 'pie',
          'data' => array(
            'labels' => $graph['graphed_variables'],
            'datasets' => array()
          )
        );
        $graph['colors'] = json_decode($graph['colors']);
        $backgroundColors = array();
        $borderColors = array();
        $graph_data = array();
        foreach($graph['graphed_variables'] as $key => $data) {
          array_push($graph_data, $variables[$data][0]['total']);
          array_push($backgroundColors, $this->rgba($graph['colors']->$data, '0.2'));
          array_push($borderColors, $this->rgba($graph['colors']->$data, '1'));
        }
        array_push($graph_setup['data']['datasets'], array(
          'data' => $graph_data,
          'backgroundColor' => $backgroundColors,
          'borderColor' => $borderColors,
          'borderWidth' => 1,
        ));
        break;
    }

    $response = array(
      'state' => 'Success',
      'setup' => $graph_setup
    );
    return response()->json($response);
  }

  public function generate_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
        'date_range' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = Input::get('date_range');
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    $report->layout = json_decode($report->layout);
    $report->variables = json_decode($report->variables);

    // Return view.
    return view('system.components.accounting.report',
     [
       'report' => $report,
       'group_by' => $report->group_by,
       'date_range' => $date_range,
    ]);
  }

  public function edit_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
        'name' => 'required',
        'group_by' => 'required',
        'variables' => 'required',
        'layout' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // TODO: Do not rely on javascript checks.

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    $report->name = Input::get('name');
    $report->group_by = Input::get('group_by');
    $report->layout = json_encode(Input::get('layout'));
    $report->variables = json_encode(Input::get('variables'));
    $report->save();

    $response = array(
      'state' => 'Success',
      'report' => $report,
      'message' => \Lang::get('controllers/journal_controller.report_updated')
    );
    return response()->json($response);
  }

  public function load_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    $report->layout = json_decode($report->layout);
    $report->variables = json_decode($report->variables);
    $response = array(
      'state' => 'Success',
      'report' => $report,
    );
    return response()->json($response);
  }

  public function edit_graph() {
    $validator = Validator::make(Input::all(),
      array(
        'graph' => 'required',
        'name' => 'required',
        'group_by' => 'required',
        'variables' => 'required',
        'colors' => 'required',
        'graphed_variables' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // TODO: Do not rely on javascript checks.

    $graph = Graph::where('id', Input::get('graph'))->first();

    if(!$graph) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.graph_not_found')
      );
      return response()->json($response);
    }

    $graph->name = Input::get('name');
    $graph->group_by = Input::get('group_by');
    $graph->graph_type = Input::get('type');
    $graph->variables = json_encode(Input::get('variables'));
    $graph->colors = json_encode(Input::get('colors'));
    $graph->graphed_variables = json_encode(Input::get('graphed_variables'));
    $graph->save();

    $response = array(
      'state' => 'Success',
      'graph' => $graph,
      'message' => \Lang::get('controllers/journal_controller.graph_updated')
    );
    return response()->json($response);
  }

  public function load_graph() {
    $validator = Validator::make(Input::all(),
      array(
        'graph' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $graph = Graph::where('id', Input::get('graph'))->first();

    if(!$graph) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.graph_not_found')
      );
      return response()->json($response);
    }

    $graph->variables = json_decode($graph->variables);
    $graph->colors = json_decode($graph->colors);
    $graph->graphed_variables = json_decode($graph->graphed_variables);
    $response = array(
      'state' => 'Success',
      'graph' => $graph,
    );
    return response()->json($response);
  }

  public function create_graph() {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
        'variables' => 'required',
        'type' => 'required',
        'group_by' => 'required',
        'colors' => 'required',
        'graphed_variables' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // TODO: We should not depend on JS checks.
    $graph = Graph::create(array(
      'name' => Input::get('name'),
      'variables' => json_encode(Input::get('variables')),
      'group_by' => Input::get('group_by'),
      'graph_type' => Input::get('type'),
      'colors' => json_encode(Input::get('colors')),
      'graphed_variables' => json_encode(Input::get('graphed_variables')),
    ));

    $response = array(
      'state' => 'Success',
      'graph' => $graph,
      'message' => \Lang::get('controllers/journal_controller.graph_created')
    );
    return response()->json($response);
  }

  public function create_report() {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
        'variables' => 'required',
        'layout' => 'required',
        'group_by' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // TODO: We should not depend on JS checks.
    $report = Report::create(array(
      'name' => Input::get('name'),
      'variables' => json_encode(Input::get('variables')),
      'group_by' => Input::get('group_by'),
      'layout' => json_encode(Input::get('layout')),
    ));

    $response = array(
      'state' => 'Success',
      'report' => $report,
      'message' => \Lang::get('controllers/journal_controller.report_created')
    );
    return response()->json($response);
  }

  public function create_entries() {
    $validator = Validator::make(Input::all(),
      array(
        'entries' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // Make sure all accounts exist and that debits and credits add up.
    $entries = Input::get('entries');
    $debit = 0;
    $credit = 0;
    $accounts = array();
    foreach($entries as $entry) {
      $debit += ($entry['type'] == 'debit') ? $entry['amount'] : 0;
      $credit += ($entry['type'] == 'credit') ? $entry['amount'] : 0;
      $account = Account::where('code', $entry['account'])->first();
      if(!$account) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/journal_controller.account_not_found')
        );
        return response()->json($response);
      }
      array_push($accounts, $entry['account']);
    }

    if($credit != $debit) {
      $response = array(
        'state' => 'Error',
        'credit' => $credit,
        'debit' => $debit,
        'error' => \Lang::get('controllers/journal_controller.credit_debit_mismatch')
      );
      return response()->json($response);
    }

    // Get branch identifier.
    $branch_identifier = Worker::where('code', Auth::user()->worker_code)->first()->branch_identifier();

    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $last_entry = DB::table('journal_entries')
          ->where('branch_identifier', $branch_identifier)
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();
        $locked_accounts = DB::table('accounts')
          ->whereIn('code', $accounts)
          ->lockForUpdate()
          ->get();

        $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;
        DB::table('journal_entries')->insert([
          ['code' => $entry_code, 'branch_identifier' => $branch_identifier, 'state' => 1]
        ]);

        // Create entry breakdown.
        foreach($entries as $entry) {
          // Get account.
          $account = Account::where('code', $entry['account'])->first();

          // Update Account.
          if(in_array($account->type, array('li', 'eq', 're'))) {
            if($entry['type'] == 'debit') {
              DB::table('accounts')->where('code', $entry['account'])
                ->decrement('amount', $entry['amount']);
            } else {
              DB::table('accounts')->where('code', $entry['account'])
                ->increment('amount', $entry['amount']);
            }
          } else {
            if($entry['type'] == 'debit') {
              DB::table('accounts')->where('code', $entry['account'])
                ->increment('amount', $entry['amount']);
            } else {
              DB::table('accounts')->where('code', $entry['account'])
                ->decrement('amount', $entry['amount']);
            }
          }
          $balance = DB::table('accounts')->where('code', $entry['account'])
            ->first()->amount;

          // Make the entry breakdown.
          DB::table('journal_entries_breakdown')->insert([
            [
              'journal_entry_code' => $entry_code,
              'branch_identifier' => $branch_identifier,
              'debit' => ($entry['type'] == 'debit') ? 1 : 0,
              'account_code' => $entry['account'],
              'description' => $entry['description'],
              'amount' => $entry['amount']
            ]
          ]);
        }
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/journal_controller.create_entries_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/journal_controller.created_entries')
    );
    return response()->json($response);
  }

  private function sum_children($journal, $code) {
    // Check if this element has been added.
    if(!$journal[$code]['added']) {
      // Check if it has children.
      if($journal[$code]['children']) {
        foreach($journal as $entry_code => $entry) {
          if($entry['parent'] == $code) {
            if($journal[$entry_code]['added']) {
              $journal[$code]['initial'] += $entry['initial'];
              $journal[$code]['final'] += $entry['final'];
              $journal[$code]['credit'] += $entry['credit'];
              $journal[$code]['debit'] += $entry['debit'];
            } else {
              $sums = $this->sum_children($journal, $entry_code);
              $journal[$code]['initial'] += $sums['initial'];
              $journal[$code]['final'] += $sums['final'];
              $journal[$code]['credit'] += $sums['credit'];
              $journal[$code]['debit'] += $sums['debit'];
            }
          }
        }
      }
    }
    $journal[$code]['added'] = true;
    return $journal[$code];
  }

  public function search_entries() {
    $validator = Validator::make(Input::all(),
      array(
        'type' => 'required',
        'date_range' => 'required',
        'offset' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = Input::get('date_range');
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.components.accounting.journal_table',
     [
       'type' => Input::get('type'),
       'date_range' => $date_range,
       'offset' => Input::get('offset')
    ]);
  }

  public function download_entries() {
    /*
    $validator = Validator::make(Input::all(),
      array(
        'type' => 'required',
        'date_range' => 'required',
      )
    );
    */
    $validator = Validator::make(Input::all(),
      array(
        'entries_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $entries_data = json_decode(Input::get('entries_data'));
    $date_range = explode(' - ', $entries_data->date_range);
    $type = $entries_data->type;
    //$date_range = Input::get('date_range');
    //$type = Input::get('type');
    //$date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Get journal data.
    $journal = array();
    $entries = array();
    switch($type) {
      case 'detail':
        $journal = DB::table('journal_entries')
          //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
          ->join('journal_entries_breakdown', function($join){
            $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
            $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
          })
          ->select('journal_entries.*', 'journal_entries_breakdown.*')
          ->whereBetween('journal_entries.entry_date', $date_range)->get();
        break;
      case 'summary':
        $accounts = \App\Account::where('code', '!=', 0)
          ->orderBy('code')
          //->orderBy('type')
          ->get();

        foreach($accounts as $account) {
          $journal[$account->code] = array(
              'name' => $account->name,
              'initial' => $account->amount,
              'final' => $account->amount,
              'credit' => 0,
              'debit' => 0,
              'added' => (!$account->has_children) ? true : false,
              'first_found' => false,
              'type' => $account->type,
              'children' => $account->has_children,
              'parent' => $account->parent_account,
            );
        }

        $entries = DB::table('journal_entries')
          //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
          ->join('journal_entries_breakdown', function($join){
            $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
            $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
          })
          ->select('journal_entries_breakdown.*')
          ->whereBetween('journal_entries.entry_date', $date_range)
          ->get();

        foreach($entries as $entry) {
          // Check if this is the first time we found an entry for this account.
          if(!$journal[$entry->account_code]['first_found']) {
            // Update it account data.
            $journal[$entry->account_code]['first_found'] = true;

            // Check if it's a debit transaction and update account data based on
            // Account type.
            if($entry->debit) {
              if(in_array($journal[$entry->account_code]['type'], array('li', 'eq', 're'))) {
                $journal[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
              } else {
                $journal[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
              }
              $journal[$entry->account_code]['debit'] += $entry->amount;
            } else {
              if(in_array($journal[$entry->account_code]['type'], array('li', 'eq', 're'))) {
                $journal[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
              } else {
                $journal[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
              }
              $journal[$entry->account_code]['credit'] += $entry->amount;
            }
            $journal[$entry->account_code]['final'] = $entry->balance;
          } else {
            if($entry->debit) {
              $journal[$entry->account_code]['debit'] += $entry->amount;
            } else {
              $journal[$entry->account_code]['credit'] += $entry->amount;
            }
            $journal[$entry->account_code]['final'] = $entry->balance;
          }
        }

        foreach($journal as $code => $entry) {
          if(!$journal[$code]['added']) {
            $sums = $this->sum_children($journal, $code);
            $journal[$code]['initial'] += $sums['initial'];
            $journal[$code]['final'] += $sums['final'];
            $journal[$code]['credit'] += $sums['credit'];
            $journal[$code]['debit'] += $sums['debit'];
          }
        }
        break;
    }

    // Prepare headers.
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".(($type == 'detail') ? \Lang::get('controllers/journal_controller.detailed_report') : \Lang::get('controllers/journal_controller.summary_report')).".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array();
    if($type == 'detail') {
      $columns = array(\Lang::get('controllers/journal_controller.date'), \Lang::get('controllers/journal_controller.account_code'),
        \Lang::get('controllers/journal_controller.description'), \Lang::get('controllers/journal_controller.debit'),
        \Lang::get('controllers/journal_controller.credit'), \Lang::get('controllers/journal_controller.balance')
      );
    } else {
      $columns = array(\Lang::get('controllers/journal_controller.account_code'), \Lang::get('controllers/journal_controller.account_name'),
        \Lang::get('controllers/journal_controller.initial'), \Lang::get('controllers/journal_controller.debit'),
        \Lang::get('controllers/journal_controller.credit'), \Lang::get('controllers/journal_controller.final'),
      );
    }
    $callback = function() use ($journal, $columns, $type) {
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);
      if($type == 'detail') {
        foreach($journal as $entry) {
          fputcsv($file, array($entry->entry_date, $entry->account_code,
            $entry->description, ($entry->debit) ? $entry->amount : '',
            (!$entry->debit) ? $entry->amount : '', $entry->balance));
        }
      } else {
        foreach($journal as $code => $entry) {
          fputcsv($file, array($code, $entry['name'], $entry['initial'],
            $entry['debit'], $entry['credit'], $entry['final'])
          );
        }
      }
      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}
