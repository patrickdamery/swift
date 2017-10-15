<?php

use Illuminate\Database\Seeder;

class init_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('currencies')->insert([
        'code' => 'cord',
        'exchange_rate' => 1,
        'buy_rate' => 1,
        'description' => 'Cordoba'
      ]);

      DB::table('measurement_units')->insert([
        'code' => '0',
        'name' => 'No Asignado'
      ]);

      DB::table('category')->insert([
        'code' => '0',
        'description' => 'No Asignado',
        'parent_code' => '0'
      ]);

      DB::table('accounts')->insert([
        'code' => '0',
        'type' => 'NA',
        'name' => 'No Asignado',
        'parent_account' => '0',
        'has_children' => 0,
        'amount' => 0,
        'currency_code' => 'cord',
        'deleted_at' => null
      ]);

      DB::table('vehicles')->insert([
        'code' => '0',
        'make' => 'No Asignado',
        'model' => 'No Asignado',
        'efficiency' => 0,
        'under_repairs' => 0,
        'type' => 0,
        'initial_value' => 0,
        'current_value' => 0,
        'currency_code' => 'cord',
        'number_plate' => '',
        'latitude' => 0,
        'longitude' => 0,
        'asset_account' => 0,
        'depreciation_account' => 0,
      ]);

      $modules = array(
        'crm' => 0,
        'staff' => 0,
        'factory' => 0,
        'vehicles' => 0,
        'accounting' => 0,
        'warehouses' => 0,
        'sales_stock' => 0,
      );
      DB::table('configuration')->insert([
        'name' => '',
        'shortname' => '',
        'ruc' => '',
        'dgi_auth' => '',
        'local_currency_code' => 'cord',
        'quote_life' => 15,
        'reservation_life' => 15,
        'charge_tip' => 0,
        'points_enabled' => 0,
        'hourly_payment' => 1,
        'points_percentage' => 0,
        'current_version' => 0.8,
        'latest_version' => 0.8,
        'auth_key' => '',
        'key_change_counter' => 0,
        'base_url' => '',
        'modules' => json_encode($modules),
        'plugins' => '{}'
      ]);

      DB::table('user_access')->insert([
        'code' => '0',
        'name' => 'N/A',
        'access' => '{"sales": {"has": 0, "sales": {"has": 0, "make_sale": {"has": 0, "points": 0, "quotation": 0}, "make_reservation": {"has": 0}, "make_subscription": {"has": 0}}, "orders": {"has": 0, "load_order": {"has": 0, "save": 0}, "make_order": {"has": 0}, "view_order": {"has": 0, "print": 0, "make_sale": 0}}, "cashbox": {"has": 0, "cashbox": {"has": 0, "bank_deposit": 0}, "transactions": {"has": 0, "search_bill": 0}, "print_requests": {"has": 0, "pay": 0}}, "clients": {"has": 0, "debts": {"has": 0, "print": 0}, "discounts": {"has": 0, "save": 0}, "view_client": {"has": 0, "save": 0, "create": 0}, "purchase_history": {"has": 0, "print": 0}}, "discounts": {"has": 0, "discounts": {"has": 0, "create": 0}}, "sales_analytics": {"has": 0}}, "staff": {"has": 0, "view_staff": {"has": 0, "view_staff": {"has": 0, "print": 0, "create": 0}}, "staff_config": {"has": 0, "view_config": {"has": 0, "general_config": 0, "accounting_config": 0}, "access_config": {"has": 0, "create": 0, "search": 0}}, "staff_payments": {"has": 0, "view_staff": {"has": 0, "loan": 0, "hour_add": 0}, "past_payments": {"has": 0}, "group_payments": {"has": 0, "pay": 0, "print": 0, "download": 0}}, "staff_analytics": {"has": 0, "view_analytics": {"has": 0}}, "staff_assistance": {"has": 0, "view_entries": {"has": 0, "print": 0, "download": 0}, "view_schedule": {"has": 0, "print": 0, "create": 0}}}, "products": {"has": 0, "providers": {"has": 0, "view_providers": {"has": 0, "save": 0, "create": 0}}, "purchases": {"has": 0, "view_purchases": {"has": 0, "print": 0}}, "categories": {"has": 0, "view_categories": {"has": 0, "create": 0}}, "suggestions": {"has": 0, "make_suggestion": {"has": 0, "save": 0, "print": 0, "generate": 0}}, "view_products": {"has": 0, "view_products": {"has": 0, "edit": 0, "create": 0}, "view_services": {"has": 0, "edit": 0, "create": 0}}, "local_purchases": {"has": 0, "purchase": {"has": 0, "pay": 0}}, "measurement_units": {"has": 0, "view_measurement_units": {"has": 0, "create": 0, "create_conversion": 0}}, "international_order": {"has": 0, "add_bill": {"has": 0}, "view_order": {"has": 0}, "importation_expense": {"has": 0}}}, "vehicles": {"has": 0, "view_routes": {"has": 0, "view_routes": {"has": 0, "create": 0}}, "view_vehicle": {"has": 0, "view_vehicle": {"has": 0, "create": 0}}, "view_journeys": {"has": 0, "view_journeys": {"has": 0, "create": 0}}}, "accounting": {"has": 0, "journal": {"has": 0, "view_entries": {"has": 0, "print": 0, "create": 0, "download": 0}}, "accounts": {"has": 0, "view_ledger": {"has": 0, "print": 0, "download": 0}, "view_accounts": {"has": 0, "create": 0}}, "currency": {"has": 0, "view_currency": {"has": 0, "save": 0, "create": 0}, "view_variation": {"has": 0}}, "bank_accounts": {"has": 0, "pos": {"has": 0, "create": 0}, "bank_loans": {"has": 0, "pay": 0, "loan": 0}, "view_accounts": {"has": 0, "create": 0, "transaction": 0}}}, "warehouses": {"has": 0, "stock": {"has": 0, "stocktake": {"has": 0, "check": 0, "print": 0, "in_system": 0}, "stocktake_report": {"has": 0}}, "receive": {"has": 0, "receive": {"has": 0}}, "dispatch": {"has": 0, "dispatch": {"has": 0}}, "warehouse": {"has": 0, "view_locations": {"has": 0, "print": 0, "create": 0}, "view_warehouse": {"has": 0, "create": 0}}, "stock_movement": {"has": 0, "stock_movement": {"has": 0, "print": 0, "download": 0}}}, "configuration": {"has": 0, "groups": {"has": 0, "view_group": {"has": 0, "create": 0}}, "branches": {"has": 0, "view_branch": {"has": 0, "save": 0, "create": 0}, "public_services": {"has": 0, "create": 0}}, "configuration": {"has": 0, "view_config": {"has": 0, "save": 0}, "modules_plugins": {"has": 0, "save": 0, "backup": 0, "update": 0, "generate": 0}}}}'
      ]);

      DB::table('user_access')->insert([
        'code' => '1',
        'name' => 'Admin',
        'access' => '{"sales": {"has": "1", "sales": {"has": 1, "make_sale": {"has": 1, "points": 1, "quotation": 1}, "make_reservation": {"has": 1}, "make_subscription": {"has": 1}}, "orders": {"has": 1, "load_order": {"has": 1, "save": 1}, "make_order": {"has": 1}, "view_order": {"has": 1, "print": 1, "make_sale": 1}}, "cashbox": {"has": 1, "cashbox": {"has": 1, "bank_deposit": 1}, "transactions": {"has": 1, "search_bill": 1}, "print_requests": {"has": 1, "pay": 1}}, "clients": {"has": 1, "debts": {"has": 1, "print": 1}, "discounts": {"has": 1, "save": 1}, "view_client": {"has": 1, "save": 1, "create": 1}, "purchase_history": {"has": 1, "print": 1}}, "discounts": {"has": 1, "discounts": {"has": 1, "create": 1}}, "sales_analytics": {"has": 1}}, "staff": {"has": 1, "view_staff": {"has": 1, "view_staff": {"has": 1, "print": 1, "create": 1}}, "staff_config": {"has": 1, "view_config": {"has": 1, "general_config": 1, "accounting_config": 1}, "access_config": {"has": 1, "create": 1, "search": 1}}, "staff_payments": {"has": 1, "view_staff": {"has": 1, "loan": 1, "hour_add": 1}, "past_payments": {"has": 1}, "group_payments": {"has": 1, "pay": 1, "print": 1, "download": 1}}, "staff_analytics": {"has": 1, "view_analytics": {"has": 1}}, "staff_assistance": {"has": 1, "view_entries": {"has": 1, "print": 1, "download": 1}, "view_schedule": {"has": 1, "print": 1, "create": 1}}}, "products": {"has": 1, "providers": {"has": 1, "view_providers": {"has": 1, "save": 1, "create": 1}}, "purchases": {"has": 1, "view_purchases": {"has": 1, "print": 1}}, "categories": {"has": 1, "view_categories": {"has": 1, "create": 1}}, "suggestions": {"has": 1, "make_suggestion": {"has": 1, "save": 1, "print": 1, "generate": 1}}, "view_products": {"has": 1, "view_products": {"has": 1, "edit": 1, "create": 1}, "view_services": {"has": 1, "edit": 1, "create": 1}}, "local_purchases": {"has": 1, "purchase": {"has": 1, "pay": 1}}, "measurement_units": {"has": 1, "view_measurement_units": {"has": 1, "create": 1, "create_conversion": 1}}, "international_order": {"has": 1, "add_bill": {"has": 1}, "view_order": {"has": 1}, "importation_expense": {"has": 1}}}, "vehicles": {"has": 1, "view_routes": {"has": 1, "view_routes": {"has": 1, "create": 1}}, "view_vehicle": {"has": 1, "view_vehicle": {"has": 1, "create": 1}}, "view_journeys": {"has": 1, "view_journeys": {"has": 1, "create": 1}}}, "accounting": {"has": 1, "journal": {"has": 1, "view_entries": {"has": 1, "print": 1, "create": 1, "download": 1}}, "accounts": {"has": 1, "view_ledger": {"has": 1, "print": 1, "download": 1}, "view_accounts": {"has": 1, "create": 1}}, "currency": {"has": 1, "view_currency": {"has": 1, "save": 1, "create": 1}, "view_variation": {"has": 1}}, "bank_accounts": {"has": 1, "pos": {"has": 1, "create": 1}, "bank_loans": {"has": 1, "pay": 1, "loan": 1}, "view_accounts": {"has": 1, "create": 1, "transaction": 1}}}, "warehouses": {"has": 1, "stock": {"has": 1, "stocktake": {"has": 1, "check": 1, "print": 1, "in_system": 1}, "stocktake_report": {"has": 1}}, "receive": {"has": 1, "receive": {"has": 1}}, "dispatch": {"has": 1, "dispatch": {"has": 1}}, "warehouse": {"has": 1, "view_locations": {"has": 1, "print": 1, "create": 1}, "view_warehouse": {"has": 1, "create": 1}}, "stock_movement": {"has": 1, "stock_movement": {"has": 1, "print": 1, "download": 1}}}, "configuration": {"has": 1, "groups": {"has": 1, "view_group": {"has": 1, "create": 1}}, "branches": {"has": 1, "view_branch": {"has": 1, "save": 1, "create": 1}, "public_services": {"has": 1, "create": 1}}, "configuration": {"has": 1, "view_config": {"has": 1, "save": 1}, "modules_plugins": {"has": 1, "save": 1, "backup": 1, "update": 1, "generate": 1}}}}'
      ]);

      DB::table('groups')->insert([
        'code' => '0',
        'name' => 'No Asignado',
        'type' => 0,
        'members' => '{}'
      ]);

      DB::table('locations')->insert([
        'code' => '0',
        'description' => 'No Asignado',
        'address' => 'No Asignado',
        'latitude' => 0,
        'longitude' => 0
      ]);

      DB::table('providers')->insert([
        'code' => '0',
        'name' => 'No Asignado',
        'phone' => '',
        'email' => '',
        'ruc' => '',
        'website' => '',
        'taxes' => 0,
        'provider_type' => 2,
        'offers_credit' => 0,
        'credit_limit' => 0,
        'credit_days' => 0,
        'ai_managed' => 0,
        'sample_range_days' => 0,
        'order_range_days' => 0,
        'location_code' => '0',
        'delivers' => 0,
        'preferred_contact_method' => '',
      ]);

      DB::table('schedules')->insert([
        'code' => '0',
        'description' => 'Estandard',
        'data' => '{"monday":{"type":"work","day_start":"08:00","day_end":"05:00","lunch_start":"12:00","lunch_end":"01:00"},"tuesday":{"type":"work","day_start":"08:00","day_end":"05:00","lunch_start":"12:00","lunch_end":"01:00"},"wednesday":{"type":"work","day_start":"08:00","day_end":"05:00","lunch_start":"12:00","lunch_end":"01:00"},"thursday":{"type":"work","day_start":"08:00","day_end":"05:00","lunch_start":"12:00","lunch_end":"01:00"},"friday":{"type":"work","day_start":"08:00","day_end":"05:00","lunch_start":"12:00","lunch_end":"01:00"},"saturday":{"type":"free"},"sunday":{"type":"off"}}'
      ]);

      DB::table('accounting_accounts')->insert([
        'retained_VAT_Account' => '0',
        'advanced_VAT_account' => '0',
        'VAT_percentage' => '15',
        'fixed_fee' => '0',
        'ISC_acccount' => '0',
        'retained_IT_account' => '0',
        'advanced_IT_account' => '0',
        'IT_percentage' => '1',
        'IT_rules' => '{}',
        'entity_type' => 'juridica',
      ]);
    }
}
