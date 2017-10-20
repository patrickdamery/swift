@php
  function convert_account_type($type) {
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

  function get_results_period($period, $group_by) {
    $results = array();
    $group_parts = preg_split('/(\(|\))/', $group_by);
    switch($group_parts[1]) {
      case 'resumen':
        array_push($results, array(
          'total' => 0
        ));
        break;
      case 'dia':
        $current = date('Y-m-d', strtotime($period[0]));
        while($current <= date('Y-m-d', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-m-d', strtotime($current.' +1 day'));
        }
        break;
      case 'semana':
        $current = date('o-W', strtotime($period[0]));
        $current_timestamp = date('Y-m-d', strtotime($period[0]));
        while($current <= date('o-W', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current_timestamp = date('Y-m-d', strtotime($current_timestamp.' +1 week'));
          $current = date('o-W', strtotime($current_timestamp));
        }
        break;
      case 'mes':
        $current = date('Y-m', strtotime($period[0]));
        while($current <= date('Y-m', strtotime($period[1]))) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-m', strtotime($current.' +1 month'));
        }
        break;
      case 'año':
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

  function get_accounts($data) {
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

  function get_account_type($code) {
    $account = \App\Account::where('code', $code)->first();
    return $account->type;
  }

  function calculate_variation($entries, $data, $group_by, $period) {
    $data = json_decode($data, true);

    $accounts = array();
    $results = get_results_period($period, $group_by);
    $group_parts = preg_split('/(\(|\))/', $group_by);

    if(array_key_exists('tipo', $data)) {
      $type = convert_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type as $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_parts[1]) {
          case 'resumen':
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
          case 'dia':
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
          case 'semana':
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
          case 'mes':
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
          case 'año':
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
      $accounts = get_accounts($data);
      $type = get_account_type($data['codigo']);
      foreach($entries as $entry) {
        switch($group_parts[1]) {
          case 'resumen':
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
          case 'dia':
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
          case 'semana':
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
          case 'mes':
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
          case 'año':
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

  function calculate_debit($entries, $data, $group_by, $period) {
    $data = json_decode($data, true);

    $accounts = array();
    $results = get_results_period($period, $group_by);

    $group_parts = preg_split('/(\(|\))/', $group_by);

    if(array_key_exists('tipo', $data)) {
      $type = convert_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type as $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_parts[1]) {
          case 'resumen':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    } else {
      $accounts = get_accounts($data);
      $type = get_account_type($data['codigo']);
      foreach($entries as $entry) {
        switch($group_parts[1]) {
          case 'resumen':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->account_code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
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

  function calculate_credit($entries, $data, $group_by, $period) {
    $data = json_decode($data, true);

    $accounts = array();
    $results = get_results_period($period, $group_by);

    $group_parts = preg_split('/(\(|\))/', $group_by);

    if(array_key_exists('tipo', $data)) {
      $type = convert_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type as $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_parts[1]) {
          case 'resumen':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    } else {
      $accounts = get_accounts($data);
      $type = get_account_type($data['codigo']);
      foreach($entries as $entry) {
        switch($group_parts[1]) {
          case 'resumen':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->account_code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
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

  function calculate_balance($entries, $data, $group_by, $period) {

  }

  function make_calculation($operations, $calculations, $period, $group_by) {
    $results = get_results_period($period, $group_by);

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

  function calculate_variable($reports, $period, $name, $data, $entries, &$variables) {
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
            $variables[$entry_parts[1]] = calculate_variable($reports, $period, $entry_parts[1], $reports['variables'][$entry_parts[1]], $entries, $variables);
            array_push($calculations, $variables[$entry_parts[1]]);
          } else {
            array_push($calculations, $variables[$entry_parts[1]]);
          }
        } else {
          // If it's not a variable make the calculation.
          switch($entry_parts[0]) {
            case 'variacion':
              array_push($calculations, calculate_variation($entries, $entry_parts[1], $data['group_by'], $period));
              break;
            case 'credito':
              array_push($calculations, calculate_credit($entries, $entry_parts[1], $data['group_by'], $period));
              break;
            case 'debito':
              array_push($calculations, calculate_debit($entries, $entry_parts[1], $data['group_by'], $period));
              break;
            case 'balance':
              array_push($calculations, calculate_balance($entries, $entry_parts[1], $data['group_by'], $period));
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
    return make_calculation($operations, $calculations, $period, $data['group_by']);
  }

  // Calculate all required variables for report.
  $entries = DB::table('journal_entries')
    //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
    ->join('journal_entries_breakdown', function($join){
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
      $variables[$name] = calculate_variable($report, $date_range, $name, $data, $entries, $variables);
    }
  }
@endphp
<div class="a4-margin">
  <div class="box-header">
    <h3 class="box-title">{{ $report['name'] }}</h3>
    <br>
    <span>@lang('accounting/journal.period')</span>
    {{ date('d/m/Y', strtotime($date_range[0])) }} - {{ date('d/m/Y', strtotime($date_range[1])) }}</span>
  </div>
  <div class="box-body">
    <div class="table table-hover">
      @foreach($report['layout'] as $index => $data)
        <div class="report-row">
          @foreach($data['columns'] as $i => $column)
            <div class="w-{{ count($data['columns']) }}">
              @if(is_array($column))
                @foreach($column as $sub_i => $sub_column)
                  <div class="report-row">
                    @php
                      $entry_parts = preg_split('/(\(|\))/', $sub_column);
                      if($entry_parts[0] == 'variable') {
                        foreach($variables[$entry_parts[1]] as $key => $result) {
                          if($key != 'total') {
                            if($result['total'] < 0) {
                              @endphp
                                <div class="report-row">
                                  <div class="col-xs-6">
                                    {{ $key }}
                                  </div>
                                  <div class="col-xs-6">
                                    ({{ abs($result['total']) }})
                                  </div>
                                </div>
                              @php
                            } else {
                              @endphp
                              <div class="report-row">
                                <div class="col-xs-6">
                                  {{ $key }}
                                </div>
                                <div class="col-xs-6">
                                  {{ $result['total'] }}
                                </div>
                              </div>
                              @php
                            }
                          } else {
                            if($result['total'] < 0) {
                              @endphp
                                <div class="report-row">
                                  ({{ abs($result['total']) }})
                                </div>
                              @php
                            } else {
                              @endphp
                                <div class="report-row">
                                  {{ $result['total'] }}
                                </div>
                              @php
                            }
                          }
                        }
                      } else {
                        @endphp
                          <p>{!! $sub_column !!}</p>
                        @php
                      }
                    @endphp
                  </div>
                @endforeach
              @else
                @php
                  $entry_parts = preg_split('/(\(|\))/', $column);
                  if($entry_parts[0] == 'variable') {
                    foreach($variables[$entry_parts[1]] as $key => $result) {
                      if($key != 'total') {
                        if($result['total'] < 0) {
                          @endphp
                            <div class="report-row">
                              <div class="col-xs-6">
                                {{ $key }}
                              </div>
                              <div class="col-xs-6">
                                ({{ abs($result['total']) }})
                              </div>
                            </div>
                          @php
                        } else {
                          @endphp
                          <div class="report-row">
                            <div class="col-xs-6">
                              {{ $key }}
                            </div>
                            <div class="col-xs-6">
                              {{ $result['total'] }}
                            </div>
                          </div>
                          @php
                        }
                      } else {
                        if($result['total'] < 0) {
                          @endphp
                            <div class="report-row">
                              ({{ abs($result['total']) }})
                            </div>
                          @php
                        } else {
                          @endphp
                            <div class="report-row">
                              {{ $result['total'] }}
                            </div>
                          @php
                        }
                      }
                    }
                  } else {
                    @endphp
                      {!! $column !!}
                    @php
                  }
                @endphp
              @endif
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>
</div>
