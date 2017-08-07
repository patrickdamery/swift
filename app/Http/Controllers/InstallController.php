<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Configuration;

class InstallController extends Controller
{

  private function check_branches_file($file) {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
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

  private function check_staff_file($file) {
    $row = 1;
    if(($handle = fopen($file, 'r')) !== FALSE) {
      while(($data = fgetcsv($handle, ',')) !== FALSE) {
        if($row != 1) {
          $num = count($data);
          if($num != 5) {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
          }
          if($data[0] == '' || $data[1] == '' || $data[2] == ''
           || $data[4] == '') {
            return array(
              'state' => 'Error',
              'error' => \Lang::get('install_controller.error_line').' '.$row
            );
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

  private function check_providers_file($file) {
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

  private function check_categories_file($file) {
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

  private function check_measurement_units_file($file) {
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

  private function check_products_file($file) {
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

  private function check_accounting_file($file) {
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

  private function check_vehicles_file($file) {
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

  private function check_warehouses_file($file) {
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

  private function check_locations_file($file) {
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
    if($validator->fails())
    {
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
    if($validator->fails())
    {
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
      if(Request::hasFile('staff')) {
        $response = array(
          'state' => 'Error',
          //'error' => \Lang::get('install_controller.missing_fields')
          'error' => 'mooo'
        );
        return response()->json($response);
      }
      $result = $this->check_staff_file($staff_file);

      if($result->state != 'Success') {
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
      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.clients').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_providers_file($providers_file);
      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.providers').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_categories_file($categories_file);
      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.categories').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_measurement_units_file($measurement_units_file);
      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.measurement_units').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_products_file($products_file);
      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.products').' '.$result['error'];
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

      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.accounting').' '.$result['error'];
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

      if($result->state != 'Success') {
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

      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.warehouses').' '.$result['error'];
        return response()->json($result);
      }
      $result = $this->check_locations_file($warehouse_locations_file);

      if($result->state != 'Success') {
        $result['error'] = \Lang::get('install_controller.locations').' '.$result['error'];
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
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
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
        "Content-Disposition" => "attachment; filename=".\Lang::get('install_controller.category').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('install_controller.category_code'), \Lang::get('install_controller.category_description'),
      \Lang::get('install_controller.category_parent_code')
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
      \Lang::get('install_controller.product_description'), \Lang::get('install_controller.product_category_code'),
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
      \Lang::get('install_controller.account_children'), \Lang::get('install_controller.account_amount')
      );
    $row_sample = array('1', '1', 'descripcion', '0', '1', 200);
    $callback = function() use ($row_sample, $columns)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, $row_sample);
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
    $row_sample = array('1', 'marca', 'modelo', 40, 1, 100000, 55000, '1', 'M156258', 0, 0);
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
