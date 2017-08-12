<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Controllers\;
//use App\Http\Controllers\InstallController;
use Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Branch;
use App\Location;
use App\Worker;
use App\User;
use App\User_Level;
use App\Configuration;
use App\Client;
use App\Account;
use App\MeasurementUnit;
use App\Product;
use App\Provider;
use App\Vehicle;
use App\Warehouse;
use App\WarehouseLocation;
use App\Category;


class InstallController extends Controller
{

  private $exists = array();

  private function is_unique($data, $unique_keys)
  {
    foreach($unique_keys as $key) {
      $this->exists[$key] = array();
    }

    foreach($unique_keys as $key) {
      if(!in_array($data[$key], $this->exists[$key])) {
        array_push($this->exists[$key], $data[$key]);
      } else {
        return array(
          'state' => 'Error'
        );
      }
    }
    return array(
      'state' => 'Success'
    );
  }

  private function check_branches_file($file)
  {
    $this->exists = array();
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        $result = $this->is_unique($data, array(0));
        if($result['state'] != 'Success') {
          $row = $result['row'];
          return array(
            'state' => 'Error',
            'error' => \Lang::get('install_controller.error_line').' '.$row,
          );
        }
        if($row != 1) {
          $num = count($data);
          if($num != 7) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[4])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[5]) || !is_numeric($data[6])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function insert_location($location, $tries)
  {
    try {
        $last_location = Location::all()->last();
        $new_code = 1;
        if($last_location != null) {
            $new_code = $last_location->code+1;
        }

        $location = Location::create(array(
          'code' => $new_code,
          'description' => $location[0],
          'latitude' => $location[1],
          'longitude' => $location[2]
        ));

        return array(
          'state' => 'Success',
          'location_code' => $location->code
        );
    } catch (\Exception $e) {
        if($tries > 3) {
          return array(
            'state' => 'Error',
            'error' => \Lang::get('install_controller.insert_failed').' locations'
          );
        } else {
          $tries++;
          return $this->insert_location($location, $tries);
        }
    }
  }

  private function upload_branches($file)
  {
    $branches = Branch::all();
    $c = count($branches);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {
            // Get data to insert into branches.
            $location = array_splice($data, 5);

            // Now insert branch location.
            $location = array($data[1], $location[0], $location[1]);
            $result = $this->insert_location($location, 1);
            if($result['state'] != 'Success') {
              return $result;
            }

            Branch::create(array(
              'code' => $data[0],
              'name' => $data[1],
              'phone' => $data[2],
              'address' => $data[3],
              'type' => $data[4],
              'location_code' => $result['location_code']
            ));
          }
          $row++;
        }
      }
      fclose($handle);
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_staff_file($file)
  {
    $row = 1;
    $this->exists = array();
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $result = $this->is_unique($data, array(0, 2));
          if($result['state'] != 'Success') {
            $row = $result['row'];
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row,
            );
          }

          $num = count($data);
          if($num != 7) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[4] != '') {
            if(($data[5] == '') || $data[6] == '') {
              return array(
                'state' => 'Error',
                'error' => \Lang::get('install_controller.error_line').' '.$row
              );
            }
          }
          if(!is_numeric($data[3])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function insert_user($user, $tries)
  {
    try {
        $last_user = User::all()->last();
        $new_code = 1;
        if($last_user != null) {
            $new_code = $last_user->code++;
        }
        $salt = uniqid();
        $encrypted_passwd = bcrypt($user[3].$salt);
        User::create(array(
          'code' => $new_code,
          'worker_code' => $user[0],
          'user_level_code' => '1',
          'username' => $user[1],
          'email' => $user[2],
          'password' => $encrypted_passwd,
          'salt' => $salt,
          'theme' => 'default',
        ));

        return array(
          'state' => 'Success'
        );
    } catch (\Exception $e) {
        if($tries > 3) {
          return array(
            'state' => 'Error',
            'error' => \Lang::get('install_controller.insert_failed').' users'
          );
        } else {
          $tries++;
          return $this->insert_user($user, $tries);
        }
    }
  }

  private function upload_staff($file)
  {
    $workers = Worker::all();
    $c = count($workers);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {
            // Create worker.
            $worker = Worker::create(array(
              'code' => $data[0],
              'name' => $data[1],
              'legal_id' => $data[2],
              'state' => 1,
              'current_branch_code' => $data[3]
            ));

            // If user is not blank then create a user for worker.
            if($data[4] != '') {
              $user = array(
                $worker->code, $data[4], $data[5], $data[6]
              );
              $result = $this->insert_user($user, 1);
              if($result['state'] != 'Success') {
                return $result;
              }
            }
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_clients_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 14) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[8]) || !is_numeric($data[9])
           || !is_numeric($data[10]) || !is_numeric($data[11])
           || !is_numeric($data[12]) || !is_numeric($data[13])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_clients($file)
  {
    $clients = Client::all();
    $c = count($clients);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {
            // Insert location.
            $location = array($data[2], $data[12], $data[13]);
            $result = $this->insert_location($location, 1);

            if($result['state'] != 'Success') {
              return $result;
            }
            // Create client.
            $client = Client::create(array(
              'code' => $data[0],
              'legal_id' => $data[1],
              'name' => $data[2],
              'company_code' => $data[3],
              'phone' => $data[4],
              'email' => $data[5],
              'address' => $data[6],
              'ocupation' => $data[7],
              'type' => $data[8],
              'has_credit' => $data[9],
              'credit_days' => $data[10],
              'credit_limit' => $data[11],
              'points' => 0,
              'discount_group_code' => '0',
              'location_code' => $result['location_code'],
              'account_code' => '0'
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_providers_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 13) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == ''
           || $data[3] == '' || $data[4] == '' || $data[5] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[7]) || !is_numeric($data[8]) || !is_numeric($data[9])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[9]) || !is_numeric($data[10]) ||
           !is_numeric($data[11]) || !is_numeric($data[12])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_providers($file)
  {
    $providers = Provider::all();
    $c = count($providers);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {
            // Now insert location.
            $location = array($data[1], $data[11], $data[12]);
            $result = $this->insert_location($location, 1);
            if($result['state'] != 'Success') {
              return $result;
            }

            // Create provider.
            $provider = Provider::create(array(
              'code' => $data[0],
              'name' => $data[1],
              'phone' => $data[2],
              'email' => $data[3],
              'ruc' => $data[4],
              'website' => $data[5],
              'taxes' => $data[6],
              'provider_type' => $data[7],
              'offers_credit' => $data[8],
              'credit_limit' => $data[9],
              'credit_days' => $data[10],
              'ai_managed' => 0,
              'sample_range_days' => 30,
              'order_range_days' => 15,
              'location_code' => $result['location_code'],
              'delivers' => 0,
              'preferred_contact_method' => 'none',
              'account_code' => '0'
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }
    return array(
      'state' => 'Success'
    );
  }

  private function check_categories_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 3) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_categories($file)
  {
    $categories = Category::all();
    $c = count($categories);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {
            // Create Categories.
            $Categories = Category::create(array(
              'code' => $data[0],
              'description' => $data[1],
              'parent_code' => $data[2]
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }
    return array(
      'state' => 'Success'
    );
  }

  private function check_measurement_units_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 2) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_measurement_units($file)
  {
    $measurement_units = MeasurementUnit::all();
    $c = count($measurement_units);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {

            // Create measurement unit.
            $measurement_unit = MeasurementUnit::create(array(
              'code' => $data[0],
              'name' => $data[1]
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }
    return array(
      'state' => 'Success'
    );
  }

  private function check_products_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 16) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == ''
           || $data[3] == '' || $data[4] == '' || $data[13] == ''
          || $data[14] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[8]) || !is_numeric($data[9]) || !is_numeric($data[15])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[5]) || !is_numeric($data[6]) ||
           !is_numeric($data[7]) || !is_numeric($data[10]) || !is_numeric($data[11])
          || !is_numeric($data[12])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_products($file)
  {
    $products = Product::all();
    $c = count($products);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {

            // Create product.
            $product = Product::create(array(
              'code' => $data[0],
              'provider_code' => $data[1],
              'description' => $data[2],
              'category_code' => $data[3],
              'onload_function' => '',
              'onsale_function' => '',
              'measurement_unit_code' => $data[4],
              'cost' => $data[5],
              'avg_cost' => $data[6],
              'price' => $data[7],
              'sellable' => $data[8],
              'sell_at_base_price' => $data[9],
              'base_price' => $data[10],
              'volume' => $data[11],
              'weight' => $data[12],
              'package_code' => $data[13],
              'package_measurement_unit_code' => $data[14],
              'order_by' => 1,
              'service' => $data[15],
              'materials' => '{}',
              'points_cost' => 0,
              'account_code' => '0',
              'alternatives' => '{}'
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_accounting_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 9) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == ''
            || $data[3] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[4]) || !is_numeric($data[6])
            || !is_numeric($data[7]) || !is_numeric($data[8])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[5])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_accounting($file)
  {
    $accounts = Account::all();
    $c = count($accounts);
    $row = 1;
    if($c == 1) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {

            // Create account.
            $account = Account::create(array(
              'code' => $data[0],
              'type' => $data[1],
              'name' => $data[2],
              'parent_account' => $data[3],
              'has_children' => $data[4],
              'amount' => $data[5],
            ));

            // Update Account Assignee if required.
            if($data[6] != 0) {
              switch($data[7]) {
                case 1:
                  // Client.
                  $client = Client::where('code', $data[8])->first();
                  $client->account_code = $account->code;
                  $client->save();
                break;
                case 2:
                  // Provider.
                  $provider = Provider::where('code', $data[8])->first();
                  $provider->account_code = $account->code;
                  $provider->save();
                break;
                case 3:
                  // Worker.
                  $worker = Worker::where('code', $data[8])->first();
                  $worker->account_code = $account->code;
                  $worker->save();
                break;
                case 4:
                  // Product.
                  $product = Product::where('code', $data[8])->first();
                  $product->account_code = $account->code;
                  $product->save();
                break;
                case 5:
                  // Vehicle.
                  $vehicle = Vehicle::where('code', $data[8])->first();
                  $vehicle->account_code = $account->code;
                  $vehicle->save();
                break;
                case 6:
                  // Branch.
                  $branch = Branch::where('code', $data[8])->first();
                  $branch->account_code = $account->code;
                  $branch->save();
                break;
              }
            }
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_vehicles_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 10) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == ''
           || $data[7] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[4])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[3]) || !is_numeric($data[5]) || !is_numeric($data[6])
            || !is_numeric($data[8]) || !is_numeric($data[9])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_vehicles($file)
  {
    $vehicles = Vehicle::all();
    $c = count($vehicles);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {

            // Create vehicle.
            $vehicle = Vehicle::create(array(
              'code' => $data[0],
              'make' => $data[1],
              'model' => $data[2],
              'efficiency' => $data[3],
              'under_repairs' => 0,
              'type' => $data[4],
              'initial_value' => $data[5],
              'current_value' => $data[6],
              'currency_code' => 'cord',
              'number_plate' => $data[7],
              'latitude' => $data[8],
              'longitude' => $data[9],
              'account_code' => '0'
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_warehouses_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 6) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[4])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[3]) || !is_numeric($data[4]) || !is_numeric($data[5])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_warehouses($file)
  {
    $warehouses = Warehouse::all();
    $c = count($warehouses);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {

            // Insert location.
            $location = array($data[1], $data[4], $data[5]);
            $result = $this->insert_location($location, 1);

            if($result['state'] != 'Success') {
              return $result;
            }

            // Create warehouse.
            $warehouse = Warehouse::create(array(
              'code' => $data[0],
              'name' => $data[1],
              'branch_code' => $data[2],
              'location_code' => $result['location_code'],
              'used_space' => 0,
              'free_space' => $data[3],
              'total_space' => $data[3]
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  private function check_locations_file($file)
  {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 6) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == ''
           || $data[3] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[4])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if(!is_numeric($data[5])) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return array(
      'state' => 'Success'
    );
  }

  private function upload_locations($file)
  {
    $locations = WarehouseLocation::all();
    $c = count($locations);
    $row = 1;
    if($c == 0) {
      if(($handle = fopen($file, 'r')) !== FALSE) {
        while(($data = fgetcsv($handle, ',')) !== FALSE) {
          if($row != 1) {

            // Create warehouse location.
            $location = WarehouseLocation::create(array(
              'code' => $data[0],
              'warehouse_code' => $data[1],
              'stand' => $data[2],
              'row' => $data[3],
              'cell' => $data[4],
              'used_space' => 0,
              'free_space' => $data[5],
              'total_space' => $data[5],
            ));
          }
          $row++;
        }
        fclose($handle);
      }
    }

    return array(
      'state' => 'Success'
    );
  }

  public function load_modules()
  {
    $config = Configuration::find(1);
    $response = array(
      'state' => 'Success',
      'modules' => json_decode($config->modules)
    );
    return response()->json($response);
  }

  public function launch_swift()
  {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
        'ruc' => 'required',
        'dgi_auth' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('install_controller.missing_fields')
      );
      return response()->json($response);
    }

    $validator = Validator::make(Request::all(),
      array(
        'branches' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('install_controller.missing_fields')
      );
      return response()->json($response);
    }

    // Get configuration.
    $config = Configuration::find(1);
    $modules =json_decode($config->modules);

    // Now check that submitted files are good.
    $branches_file = Request::file('branches');
    if(Request::hasFile('branches')) {
      $result = $this->check_branches_file($branches_file);

      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.branches').' '.$result['error'];
        return response()->json($result);
      }
    }
    if($modules->staff) {
      $staff_file = Request::file('staff');
      if(!Request::hasFile('staff')) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('install_controller.missing_fields')
        );
        return response()->json($response);
      }
      $result = $this->check_staff_file($staff_file);

      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.staff').' '.$result['error'];
        return response()->json($result);
      }
    }
    if($modules->sales_stock) {
      $clients_file = Request::file('clients');
      $providers_file = Request::file('providers');
      $categories_file = Request::file('categories');
      $measurement_units_file = Request::file('measurement_units');
      $products_file = Request::file('products');
      if(!Request::hasFile('clients') || !Request::hasFile('providers') ||
        !Request::hasFile('categories') || !Request::hasFile('measurement_units') ||
        !Request::hasFile('products')) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('install_controller.missing_fields')
        );
        return response()->json($response);
      }
      $result = $this->check_clients_file($clients_file);
      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.clients').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_providers_file($providers_file);
      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.providers').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_categories_file($categories_file);
      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.categories').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_measurement_units_file($measurement_units_file);
      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.measurement_units').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_products_file($products_file);
      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.products').' '.$result['error'];
        return response()->json($result);
      }
    }

    if($modules->vehicles) {
      $vehicles_file = Request::file('vehicles');
      if(!Request::hasFile('vehicles')) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('install_controller.missing_fields')
        );
        return response()->json($response);
      }
      $result = $this->check_vehicles_file($vehicles_file);

      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.vehicles').' '.$result['error'];
        return response()->json($result);
      }
    }

    if($modules->warehouses) {
      $warehouses_file = Request::file('warehouses');
      $warehouse_locations_file = Request::file('locations');
      if(!Request::hasFile('warehouses') || !Request::hasFile('locations')) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('install_controller.missing_fields')
        );
        return response()->json($response);
      }
      $result = $this->check_warehouses_file($warehouses_file);

      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.warehouses').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_locations_file($warehouse_locations_file);

      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.locations').' '.$result['error'];
        return response()->json($result);
      }
    }

    if($modules->accounting) {
      $accounting_file = Request::file('accounting');
      if(!Request::hasFile('accounting')) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('install_controller.missing_fields')
        );
        return response()->json($response);
      }
      $result = $this->check_accounting_file($accounting_file);

      if($result['state'] != 'Success') {
        $result['error'] = \Lang::get('install_controller.accounting').' '.$result['error'];
        return response()->json($result);
      }
    }

    $branches_file = Request::file('branches');
    $result = $this->upload_branches($branches_file);

    if($result['state'] != 'Success') {
      return response()->json($result);
    }

    if($modules->staff) {
      $staff_file = Request::file('staff');
      $result = $this->upload_staff($staff_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }
    }

    if($modules->sales_stock) {
      $clients_file = Request::file('clients');
      $providers_file = Request::file('providers');
      $categories_file = Request::file('categories');
      $measurement_units_file = Request::file('measurement_units');
      $products_file = Request::file('products');

      $result = $this->upload_clients($clients_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }

      $result = $this->upload_providers($providers_file);

      if($result['state'] != 'Success') {
        return response()->json(array('m' => 'moo'));
        return response()->json($result);
      }

      $result = $this->upload_categories($categories_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }

      $result = $this->upload_measurement_units($measurement_units_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }

      $result = $this->upload_products($products_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }
    }

    if($modules->vehicles) {
      $vehicles_file = Request::file('vehicles');
      $result = $this->upload_vehicles($vehicles_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }
    }

    if($modules->warehouses) {
      $warehouses_file = Request::file('warehouses');
      $warehouse_locations_file = Request::file('locations');

      $result = $this->upload_warehouses($warehouses_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }

      $result = $this->upload_locations($warehouse_locations_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }
    }

    if($modules->accounting) {
      $accounting_file = Request::file('accounting');

      $result = $this->upload_accounting($accounting_file);

      if($result['state'] != 'Success') {
        return response()->json($result);
      }
    }

    // Get configuration and save data.
    $config->name = Input::get('name');
    $config->ruc = Input::get('ruc');
    $config->dgi_auth = Input::get('dgi_auth');
    $config->save();

    $response = array(
      'state' => 'Success'
    );
    return response()->json($response);
  }

  public function download_branches()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.branches').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.business_code'), \Lang::get('install_controller.business_name'),
      \Lang::get('install_controller.business_phone'), \Lang::get('install_controller.business_address'),
      \Lang::get('install_controller.business_type'), \Lang::get('install_controller.business_lat'),
      \Lang::get('install_controller.business_lng'));
    $row_sample = array('1', 'nombre', 22226666, 'Managua', '1', 0, 0);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_staff()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.staff').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.staff_code'), \Lang::get('install_controller.staff_name'),
      \Lang::get('install_controller.staff_legal_id'), \Lang::get('install_controller.staff_branch_code'),
      \Lang::get('install_controller.staff_username'), \Lang::get('install_controller.staff_email'),
      \Lang::get('install_controller.staff_password'));
    $row_sample = array(1, 'nombre', '888555550000B', '1', 'usuario', 'correo@correo.com', 'abc123');
    $row2_sample = array(2, 'nombre 2', '888555550000C', '1', '', '', '');
    $callback = function() use ($row_sample, $row2_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fputcsv($file, $row2_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_clients()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.clients').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.clients_code'), \Lang::get('install_controller.clients_id'),
      \Lang::get('install_controller.clients_name'), \Lang::get('install_controller.clients_company_code'),
      \Lang::get('install_controller.clients_phone'), \Lang::get('install_controller.clients_email'),
      \Lang::get('install_controller.clients_address'), \Lang::get('install_controller.clients_ocupation'),
      \Lang::get('install_controller.clients_type'), \Lang::get('install_controller.clients_credit'),
      \Lang::get('install_controller.clients_credit_days'), \Lang::get('install_controller.clients_credit_limit'),
      \Lang::get('install_controller.clients_lat'), \Lang::get('install_controller.clients_lng')
    );
    $row_sample = array('1', '3338888880000B', 'nombre', '', 22226666, 'client@correo.com', 'Managua', 'Ing. Industrial',
      0, 1, 15, 3000, 0, 0);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_warehouses()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.warehouses').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.warehouse_code'), \Lang::get('install_controller.warehouse_name'),
      \Lang::get('install_controller.warehouse_branch'), \Lang::get('install_controller.warehouse_total_space'),
      \Lang::get('install_controller.warehouse_lat'), \Lang::get('install_controller.warehouse_lng'));
    $row_sample = array("1", 'nombre', "1", 300, 0, 0);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_warehouse_locations()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.warehouse_locations').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.warehouse_location_code'), \Lang::get('install_controller.warehouse_location_w_code'),
      \Lang::get('install_controller.warehouse_location_stand'), \Lang::get('install_controller.warehouse_location_row'),
      \Lang::get('install_controller.warehouse_location_cell'), \Lang::get('install_controller.warehouse_location_total_space'));
    $row_sample = array("1", '1', "A", 1, 1, 10);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_providers()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.providers').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.provider_code'), \Lang::get('install_controller.provider_name'),
      \Lang::get('install_controller.provider_phone'), \Lang::get('install_controller.provider_email'),
      \Lang::get('install_controller.provider_ruc'), \Lang::get('install_controller.provider_website'),
      \Lang::get('install_controller.provider_taxes'), \Lang::get('install_controller.provider_type'),
      \Lang::get('install_controller.provider_credit'), \Lang::get('install_controller.provider_credit_limit'),
      \Lang::get('install_controller.provider_credit_days'), \Lang::get('install_controller.provider_lat'),
      \Lang::get('install_controller.provider_lng'));
    $row_sample = array('1', 'nombre', 22226666, 'correo@correo.com', 'J0000111188881', 'web.com', '1', '1',
     '1', 3000, 15, 0, 0);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_categories()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.Categories').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.Categories_code'), \Lang::get('install_controller.Categories_description'),
      \Lang::get('install_controller.Categories_parent_code')
      );
    $row_sample = array('1', 'descripcion', '0');
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_measurement_units()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.measurement_units').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.measurement_code'), \Lang::get('install_controller.measurement_name')
      );
    $row_sample = array('1', 'descripcion');
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_products()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.products').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.product_code'), \Lang::get('install_controller.provider_code'),
      \Lang::get('install_controller.product_description'), \Lang::get('install_controller.product_Categories_code'),
      \Lang::get('install_controller.product_measurement_code'), \Lang::get('install_controller.product_cost'),
      \Lang::get('install_controller.product_avg_cost'), \Lang::get('install_controller.product_price'),
      \Lang::get('install_controller.product_sellable'), \Lang::get('install_controller.product_base'),
      \Lang::get('install_controller.product_base_price'), \Lang::get('install_controller.product_volume'),
      \Lang::get('install_controller.product_weight'), \Lang::get('install_controller.product_package_code'),
      \Lang::get('install_controller.product_package_measurement_code'), \Lang::get('install_controller.service')
      );
    $row_sample = array('1', '1', 'producto o servicio', '1', '1', 20, 20, 30, '1', '1', 25, 1, 1, '1', '1', '1');
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_accounting()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.accounting').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.account_code'), \Lang::get('install_controller.account_type'),
      \Lang::get('install_controller.account_name'), \Lang::get('install_controller.account_parent_code'),
      \Lang::get('install_controller.account_children'), \Lang::get('install_controller.account_amount'),
      \Lang::get('install_controller.account_assigned'), \Lang::get('install_controller.account_assignee_type'),
      \Lang::get('install_controller.account_assignee_code')
      );
    $row_sample = array('1', '1', 'descripcion', '0', '1', 200, 0, 0, 0);
    $row2_sample = array('2', '1', 'descripcion 2', '0', '1', 200, 1, 1, 1);
    $callback = function() use ($row_sample, $row2_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fputcsv($file, $row2_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }

  public function download_vehicles()
  {
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.vehicles').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.vehicle_code'), \Lang::get('install_controller.vehicle_make'),
      \Lang::get('install_controller.vehicle_model'), \Lang::get('install_controller.vehicle_efficiency'),
      \Lang::get('install_controller.vehicle_type'), \Lang::get('install_controller.vehicle_initial_value'),
      \Lang::get('install_controller.vehicle_current_value'), \Lang::get('install_controller.vehicle_plate'),
      \Lang::get('install_controller.vehicle_lat'), \Lang::get('install_controller.vehicle_lng'),
    );
    $row_sample = array('1', 'marca', 'modelo', 40, 1, 100000, 55000, 'M156258', 0, 0);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }
}
