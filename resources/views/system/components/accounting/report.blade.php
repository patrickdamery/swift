@php

  $entries = DB::table('journal_entries')
    ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
    ->select('journal_entries.*', 'journal_entries_breakdown.*')
    ->whereBetween('journal_entries.entry_date', $date_range)->get();

  $variables = {};
  $max = 50;

  function get_account_type($type) {
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
    switch($group_by) {
      case 'resumen':
        array_push($results, array(
          'total' => 0
        ));
        break;
      case 'dia':
        $current = date('Y-m-d', strtotime($period[0]));
        while($current != $period[1]) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-m-d', strtotime($current.' +1 day'));
        }
        break;
      case 'semana':
        $current = date('Y-W', strtotime($period[0]));
        while($current != $period[1]) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-W', strtotime($current.' +1 week'));
        }
        break;
      case 'mes':
        $current = date('Y-m', strtotime($period[0]));
        while($current != $period[1]) {
          $results[$current] = array(
            'total' => 0
          );
          $current = date('Y-m', strtotime($current.' +1 month'));
        }
        break;
      case 'año':
        $current = date('Y', strtotime($period[0]));
        while($current != $period[1]) {
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
            'codigo': $child->code,
            'sub': 1
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

  function calculate_variation($entries, $data, $group_by, $period) {
    $data = json_decode($data);

    $accounts = array();
    $results = get_results_period($period, $group_by);

    if(array_key_exists('tipo', $data)) {
      $type = get_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type, $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_by) {
          case 'resumen':
            if(in_array($entry->code, $accounts)) {
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
            if(in_array($entry->code, $accounts)) {
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
            if(in_array($entry->code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'mes':
            if(in_array($entry->code, $accounts)) {
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
            if(in_array($entry->code, $accounts)) {
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
      foreach($entries as $entry) {
        switch($group_by) {
          case 'resumen':
            if(in_array($entry->code, $accounts)) {
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
            if(in_array($entry->code, $accounts)) {
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
            if(in_array($entry->code, $accounts)) {
              $debits = array('as', 'dr', 'ex');
              if(in_array($type, $debits)) {
                if($entry->debit) {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                } else {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                }
              } else {
                if($entry->debit) {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] -= $entry->amount;
                } else {
                  $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
                }
              }
            }
            break;
          case 'mes':
            if(in_array($entry->code, $accounts)) {
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
            if(in_array($entry->code, $accounts)) {
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
    $data = json_decode($data);

    $accounts = array();
    $results = get_results_period($period, $group_by);

    if(array_key_exists('tipo', $data)) {
      $type = get_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type, $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_by) {
          case 'resumen':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    } else {
      $accounts = get_accounts($data);
      foreach($entries as $entry) {
        switch($group_by) {
          case 'resumen':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->code, $accounts)) {
              if($entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
            if(in_array($entry->code, $accounts)) {
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
    $data = json_decode($data);

    $accounts = array();
    $results = get_results_period($period, $group_by);

    if(array_key_exists('tipo', $data)) {
      $type = get_account_type($data['tipo']);
      $accounts_type = \App\Account::where('type', $type)->get();
      foreach($accounts_type, $account) {
        array_push($accounts, $account->code);
      }

      foreach($entries as $entry) {
        switch($group_by) {
          case 'resumen':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
        }
      }
    } else {
      $accounts = get_accounts($data);
      foreach($entries as $entry) {
        switch($group_by) {
          case 'resumen':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[0]['total'] += $entry->amount;
              }
            }
            break;
          case 'dia':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m-d', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'semana':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-W', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'mes':
            if(in_array($entry->code, $accounts)) {
              if(!$entry->debit) {
                $results[date('Y-m', strtotime($entry->entry_date))]['total'] += $entry->amount;
              }
            }
            break;
          case 'año':
            if(in_array($entry->code, $accounts)) {
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
      $results[$key]['total'] += $calculation[0][$key]['total'];
      $count = 1;
      foreach($operations as $operation) {
        switch($operation) {
          case '+':
            $results[$key]['total'] += $calculation[$count][$key]['total'];
            break;
          case '-':
            $results[$key]['total'] -= $calculation[$count][$key]['total'];
            break;
          case '*':
            $results[$key]['total'] *= $calculation[$count][$key]['total'];
            break;
          case '/':
            $results[$key]['total'] /= $calculation[$count][$key]['total'];
            break;
        }
        $count++;
      }
    }
    return $results;
  }

  function calculate_variable($reports, $period, $name, $data, $entries, $variables) {
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
            calculate_variable($reports, $period, $entry_parts[1], $reports[$entry_parts[1]], $entries, $variables);
            //calculate_variable($entry_parts[1], $reports[$data], $entries, $variables, $period)
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
    $variables[$name] = make_calculation($operations, $calculations, $period, $data['group_by']);
  }

  // Calculate all required variables for report.
  foreach($report->variables, $name => $data) {
    // Make sure we haven't already calculated this variable.
    if(!array_key_exists($name, $variables) {
      calculate_variable($report, $date_range, $name, $data, $entries, $variables);
    }
  }











  /* switch($type) {
    case 'detail':
      $report = DB::table('report_entries')
        ->join('report_entries_breakdown', 'report_entries.code', 'report_entries_breakdown.report_entry_code')
        ->select('report_entries.*', 'report_entries_breakdown.*')
        ->whereBetween('report_entries.entry_date', $date_range);
      break;
    case 'summary':
      $accounts = \App\Account::where('code', '!=', 0)
        ->orderBy('code')
        //->orderBy('type')
        ->get();

      foreach($accounts as $account) {
        $report[$account->code] = array(
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

      $entries = DB::table('report_entries')
        ->join('report_entries_breakdown', 'report_entries.code', 'report_entries_breakdown.report_entry_code')
        ->select('report_entries_breakdown.*')
        ->whereBetween('report_entries.entry_date', $date_range)
        ->get();variation

      foreach($entries as $entry) {
        // Check if this is the first time we found an entry for this account.
        if(!$report[$entry->account_code]['first_found']) {
          // Update it account data.
          $report[$entry->account_code]['first_found'] = true;

          // Check if it's a debit transaction and update account data based on
          // Account type.
          if($entry->debit) {
            if(in_array($report[$entry->account_code]['type'], array('li', 'eq', 're'))) {
              $report[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
            } else {
              $report[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
            }
            $report[$entry->account_code]['debit'] += $entry->amount;
          } else {
            if(in_array($report[$entry->account_code]['type'], array('li', 'eq', 're'))) {
              $report[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
            } else {
              $report[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
            }
            $report[$entry->account_code]['credit'] += $entry->amount;
          }
          $report[$entry->account_code]['final'] = $entry->balance;
        } else {
          if($entry->debit) {
            $report[$entry->account_code]['debit'] += $entry->amount;
          } else {
            $report[$entry->account_code]['credit'] += $entry->amount;
          }
          $report[$entry->account_code]['final'] = $entry->balance;
        }
      }

      foreach($report as $code => $entry) {
        if(!$report[$code]['added']) {
          $sums = sum_children($report, $code);
          $report[$code]['initial'] += $sums['initial'];
          $report[$code]['final'] += $sums['final'];
          $report[$code]['credit'] += $sums['credit'];
          $report[$code]['debit'] += $sums['debit'];
        }
      }
      break;
  }*/

  $records = count($result);
  $pages = ceil($records/$max);

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/report.entries')</h3>
  <br>
  @if($type == 'detail')
    <span>@lang('accounting/report.detailed_period')
  @else
    <span>@lang('accounting/report.summary_period')
  @endif
    {{ date('d-m-Y', strtotime($date_range[0])) }} - {{ date('d-m-Y', strtotime($date_range[1])) }}</span>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      @switch($type)
        @case('detail')
          <tr>
            <th>@lang('accounting/report.date')</th>
            <th>@lang('accounting/report.account_code')</th>
            <th>@lang('accounting/report.description')</th>
            <th>@lang('accounting/report.debit')</th>
            <th>@lang('accounting/report.credit')</th>
            <th>@lang('accounting/report.balance')</th>
          </tr>
          @break
        @case('summary')
          <tr>
            <th>@lang('accounting/report.account_code')</th>
            <th>@lang('accounting/report.account_name')</th>
            <th>@lang('accounting/report.initial')</th>
            <th>@lang('accounting/report.debit')</th>
            <th>@lang('accounting/report.credit')</th>
            <th>@lang('accounting/report.final')</th>
          </tr>
        @break
      @endswitch
    </thead>
    <tbody>
      @php
        $count = 0;
      @endphp
      @switch($type)
        @case('detail')
          @foreach($report as $entry)
            <tr class="report-entry-row" id="entry-{{ $entry->code }}">
              <td>{{ date('d/m/Y h:i:s a', strtotime($entry->entry_date)) }}</td>
              <td>{{ $entry->account_code }}</td>
              <td>{{ $entry->description }}</td>
              <td>{{ ($entry->debit) ? $entry->amount : '' }}</td>
              <td>{{ (!$entry->debit) ? $entry->amount : '' }}</td>
              <td>{{ $entry->balance }}</td>
            </tr>
          @endforeach
          @break
        @case('summary')
          @foreach($report as $code => $entry)
            @if($count > $offset*$max && $count < $max+($offset*$max))
              <tr class="report-entry-row">
                <td>{{ $code }}</td>
                <td>{{ $entry['name'] }}</td>
                <td>{{ $entry['initial'] }}</td>
                <td>{{ $entry['debit'] }}</td>
                <td>{{ $entry['credit'] }}</td>
                <td>{{ $entry['final'] }}</td>
              </tr>
            @endif
            @php
              $count++;
            @endphp
          @endforeach
          @break
      @endswitch
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right report-pagination">
    <li><a href="#" id="report-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="report-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="report-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="report-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="report-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="report-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="report-pagination-last">»</a></li>
  </ul>
</div>
