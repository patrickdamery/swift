<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_orders', function (Blueprint $table) {
            $table->foreign('provider_code')->references('code')->on('providers');
            $table->foreign('branch_code')->references('code')->on('branches');
        });
        Schema::table('ai_orders_breakdown', function (Blueprint $table) {
            $table->foreign('ai_order_code')->references('code')->on('ai_orders');
            $table->foreign('product_code')->references('code')->on('products');
        });
        Schema::table('assets', function (Blueprint $table) {
          $table->foreign('asset_code')->references('code')->on('accounts');
          $table->foreign('depreciation_code')->references('code')->on('accounts');
          $table->foreign('expense_code')->references('code')->on('accounts');
        });
        Schema::table('assets_depreciation', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->foreign('account_code')->references('code')->on('accounts');
        });
        Schema::table('branch_settings', function (Blueprint $table) {
            $table->foreign('vehicle_group_code')->references('code')->on('groups');
            $table->foreign('worker_group_code')->references('code')->on('groups');
        });
        Schema::table('vehicle_cargoes', function (Blueprint $table) {
            $table->foreign('journey_code')->references('code')->on('journeys');
        });
        Schema::table('vehicle_cargo_breakdown', function (Blueprint $table) {
            $table->foreign('product_code')->references('code')->on('products');
        });
        Schema::table('utilities', function (Blueprint $table) {
            $table->foreign('account_code')->references('code')->on('accounts');
            $table->foreign('provider_code')->references('code')->on('providers');
        });
        Schema::table('utility_bills', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('cashboxes', function (Blueprint $table) {
            $table->foreign('worker_code')->references('code')->on('workers');
        });
        Schema::table('cashbox_transactions', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('cashbox_receipt', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->foreign('client_code')->references('code')->on('clients');
        });
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreign('from_code')->references('code')->on('workers');
            $table->foreign('to_code')->references('code')->on('workers');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('location_code')->references('code')->on('locations');
            $table->index('type');
            $table->index('has_credit');
        });
        Schema::table('credit_notes', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->index('state');
        });
        Schema::table('contracts', function (Blueprint $table) {
            $table->foreign('account_code')->references('code')->on('accounts');
            $table->index('state');
        });
        Schema::table('contracts_breakdown', function (Blueprint $table) {
            $table->foreign('product_code')->references('code')->on('products');
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->index('type');
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('worker_code')->references('code')->on('workers');
        });
        Schema::table('production_order', function (Blueprint $table) {
            $table->index('type');
            $table->index('priority');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('sales_account')->references('code')->on('accounts');
            $table->foreign('returns_account')->references('code')->on('accounts');
            $table->foreign('measurement_unit_code')->references('code')->on('measurement_units');
            $table->foreign('package_measurement_unit_code')->references('code')->on('measurement_units');
            $table->foreign('category_code')->references('code')->on('category');
            $table->foreign('provider_code')->references('code')->on('providers');
            $table->foreign('currency_code')->references('code')->on('currencies');
        });
        Schema::table('other_expenses', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('product_production', function (Blueprint $table) {
            $table->foreign('branch_code')->references('code')->on('branches');
        });
        Schema::table('production_expenses', function (Blueprint $table) {
            $table->index('stage');
        });
        Schema::table('production_stages', function (Blueprint $table) {
            $table->foreign('worker_code')->references('code')->on('workers');
            $table->index('stage');
        });
        Schema::table('providers', function (Blueprint $table) {
            $table->foreign('location_code')->references('code')->on('locations');
            $table->index('provider_type');
        });
        Schema::table('provider_bills_payments', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->index('transaction_type');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('worker_code')->references('code')->on('workers');
            $table->foreign('discount_code')->references('code')->on('discount_requests');
        });
        Schema::table('quotations_breakdown', function (Blueprint $table) {
            $table->foreign('discount_code')->references('code')->on('discount_requests');
        });
        Schema::table('discount_requests', function (Blueprint $table) {
            $table->foreign('requested_by_code')->references('code')->on('workers');
            $table->foreign('decided_by_code')->references('code')->on('workers');
            $table->index('used');
            $table->index('created');
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->index('state');
            $table->index('created');
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->foreign('pos_code')->references('code')->on('pos');
            $table->index('state');
            $table->index('credit_sale');
        });
        Schema::table('stocktakes', function (Blueprint $table) {
            $table->foreign('warehouse_code')->references('code')->on('warehouses');
            $table->foreign('worker_code')->references('code')->on('workers');
            $table->index('state');
            $table->index('created');
        });
        Schema::table('stocktakes_breakdown', function (Blueprint $table) {
            $table->index('state');
        });
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('tabs', function (Blueprint $table) {
            $table->foreign('discount_code')->references('code')->on('discount_requests');
        });
        Schema::table('journeys', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->foreign('driver_code')->references('code')->on('workers');
            $table->foreign('vehicle_code')->references('code')->on('vehicles');
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->foreign('depreciation_account')->references('code')->on('accounts');
            $table->foreign('asset_account')->references('code')->on('accounts');
        });
        Schema::table('client_interactions', function (Blueprint $table) {
            $table->foreign('worker_code')->references('code')->on('workers');
        });
        Schema::table('worker_loans', function (Blueprint $table) {
            $table->foreign('payment_code')->references('code')->on('worker_payments');
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('worker_savings', function (Blueprint $table) {
            $table->foreign('account_code')->references('code')->on('accounts');
        });
        Schema::table('worker_hours', function (Blueprint $table) {
            $table->index('processed');
        });
        Schema::table('workers_income', function (Blueprint $table) {
            $table->foreign('payment_code')->references('code')->on('worker_payments');
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('worker_payments', function (Blueprint $table) {
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        });
        Schema::table('importation_orders_breakdown', function (Blueprint $table) {
            $table->foreign('product_code')->references('code')->on('products');
        });
        Schema::table('warehouses', function (Blueprint $table) {
            $table->foreign('location_code')->references('code')->on('locations');
        });
        Schema::table('workers', function (Blueprint $table) {
            $table->foreign('configuration_code')->references('id')->on('worker_settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai_orders', function (Blueprint $table) {
            $table->dropForeign(['provider_code']);
            $table->dropForeign(['branch_code']);
        });
        Schema::table('ai_orders_breakdown', function (Blueprint $table) {
            $table->dropForeign(['ai_order_code']);
            $table->dropForeign(['product_code']);
        });
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['asset_code']);
            $table->dropForeign(['depreciation_code']);
            $table->dropForeign(['expense_code']);
        });
        Schema::table('assets_depreciation', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropForeign(['account_code']);
        });
        Schema::table('branch_settings', function (Blueprint $table) {
            $table->dropForeign(['vehicle_group_code']);
            $table->dropForeign(['worker_group_code']);
        });
        Schema::table('vehicle_cargoes', function (Blueprint $table) {
            $table->dropForeign(['journey_code']);
        });
        Schema::table('vehicle_cargo_breakdown', function (Blueprint $table) {
            $table->dropForeign(['product_code']);
        });
        Schema::table('utilities', function (Blueprint $table) {
            $table->dropForeign(['account_code']);
            $table->dropForeign(['provider_code']);
        });
        Schema::table('utility_bills', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('cashboxes', function (Blueprint $table) {
            $table->dropForeign(['worker_code']);
        });
        Schema::table('cashbox_transactions', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('cashbox_receipt', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
            $table->dropForeign(['client_code']);
        });
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['from_code']);
            $table->dropForeign(['to_code']);
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['location_code']);
            $table->dropIndex(['type']);
            $table->dropIndex(['has_credit']);
        });
        Schema::table('credit_notes', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
            $table->dropIndex(['state']);
        });
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['account_code']);
            $table->dropIndex(['state']);
        });
        Schema::table('contracts_breakdown', function (Blueprint $table) {
            $table->dropForeign(['product_code']);
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->dropIndex(['type']);
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['worker_code']);
        });
        Schema::table('production_order', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['priority']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['sales_account']);
            $table->dropForeign(['returns_account']);
            $table->dropForeign(['measurement_unit_code']);
            $table->dropForeign(['package_measurement_unit_code']);
            $table->dropForeign(['category_code']);
            $table->dropForeign(['provider_code']);
            $table->dropForeign(['currency_code']);
        });
        Schema::table('other_expenses', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('production_expenses', function (Blueprint $table) {
            $table->dropIndex(['stage']);
        });
        Schema::table('production_stages', function (Blueprint $table) {
            $table->dropForeign(['worker_code']);
            $table->dropIndex(['stage']);
        });
        Schema::table('product_production', function (Blueprint $table) {
            $table->dropForeign(['branch_code']);
        });
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign(['location_code']);
            $table->dropIndex(['provider_type']);
        });
        Schema::table('provider_bills_payments', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
            $table->dropIndex(['transaction_type']);
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['worker_code']);
            $table->dropForeign(['discount_code']);
        });
        Schema::table('quotations_breakdown', function (Blueprint $table) {
            $table->dropForeign(['discount_code']);
        });
        Schema::table('discount_requests', function (Blueprint $table) {
            $table->dropForeign(['requested_by_code']);
            $table->dropForeign(['decided_by_code']);
            $table->dropIndex(['used']);
            $table->dropIndex(['created']);
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
            $table->dropIndex(['state']);
            $table->dropIndex(['created']);
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
            $table->dropForeign(['pos_code']);
            $table->dropIndex(['state']);
            $table->dropIndex(['credit_sale']);
        });
        Schema::table('stocktakes', function (Blueprint $table) {
            $table->dropForeign(['warehouse_code']);
            $table->dropForeign(['worker_code']);
            $table->dropIndex(['state']);
            $table->dropIndex(['created']);
        });
        Schema::table('stocktakes_breakdown', function (Blueprint $table) {
            $table->dropIndex(['state']);
        });
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('tabs', function (Blueprint $table) {
            $table->dropForeign(['discount_code']);
        });
        Schema::table('journeys', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
            $table->dropForeign(['driver_code']);
            $table->dropForeign(['vehicle_code']);
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['asset_account']);
            $table->dropForeign(['depreciation_account']);
        });
        Schema::table('client_interactions', function (Blueprint $table) {
            $table->dropForeign(['worker_code']);
        });
        Schema::table('worker_loans', function (Blueprint $table) {
            $table->dropForeign(['payment_code']);
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('worker_savings', function (Blueprint $table) {
            $table->dropForeign(['account_code']);
        });
        Schema::table('worker_hours', function (Blueprint $table) {
            $table->dropIndex(['processed']);
        });
        Schema::table('workers_income', function (Blueprint $table) {
            $table->dropForeign(['payment_code']);
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('worker_payments', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_code']);
            $table->dropForeign(['branch_identifier']);
        });
        Schema::table('importation_orders_breakdown', function (Blueprint $table) {
            $table->dropForeign(['product_code']);
        });
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropForeign(['location_code']);
        });
        Schema::table('workers', function (Blueprint $table) {
            $table->dropForeign(['configuration_code']);
        });
    }
}
