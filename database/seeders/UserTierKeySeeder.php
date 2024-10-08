<?php

namespace Database\Seeders;

use App\Models\Tier;
use App\Models\UserTierKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTierKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $salesTaxExemption = UserTierKey::create([
            'name' => 'Sales Tax Exemption',
            'identifier' => 'sales_tax_exemption',
            'data_type' => 'boolean',
            'is_active' => true,
        ]);
        $insertedKeys['sales_tax_exemption'] = $salesTaxExemption;

        // Add conditional fields based on Sales Tax Exemption
        $insertedKeys['organization_name'] = UserTierKey::create([
            'name' => 'Organization Name',
            'identifier' => 'organization_name',
            'data_type' => 'string',
            'parent_key_id' => $salesTaxExemption->id,
            'condition_value' => '1', // 1 for true (checkbox checked)
        ]);

        $insertedKeys['sales_tax_exemption_reason'] = UserTierKey::create([
            'name' => 'Sales Tax Exemption Reason',
            'identifier' => 'sales_tax_exemption_reason',
            'data_type' => 'dropdown',
            'parent_key_id' => $salesTaxExemption->id,
            'condition_value' => '1',
            'dropdown_values' => json_encode(['Government', 'Charity', 'Resale']), // Dropdown options
        ]);

        $insertedKeys['sales_tax_exemption_explanation'] = UserTierKey::create([
            'name' => 'Sales Tax Exemption Explanation (Other)',
            'identifier' => 'sales_tax_exemption_explanation',
            'data_type' => 'string',
            'parent_key_id' => $salesTaxExemption->id,
            'condition_value' => '1',
        ]);

        $insertedKeys['sales_tax_exemption_expiration_date'] = UserTierKey::create([
            'name' => 'Expiration Date',
            'identifier' => 'sales_tax_exemption_expiration_date',
            'data_type' => 'date',
            'parent_key_id' => $salesTaxExemption->id,
            'condition_value' => '1',
        ]);

        $insertedKeys['sales_tax_exemption_proof'] = UserTierKey::create([
            'name' => 'Proof of Sales Tax Exemption',
            'identifier' => 'sales_tax_exemption_proof',
            'data_type' => 'file',
            'parent_key_id' => $salesTaxExemption->id,
            'condition_value' => '1',
        ]);

        // Define all other unique keys without any tier-specific prefixes
        $keys = [
            ['name' => 'First Name', 'identifier' => 'first_name', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Last Name', 'identifier' => 'last_name', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Confirm Over 18', 'identifier' => 'confirm_over_18', 'data_type' => 'boolean', 'is_active' => true],
            ['name' => 'Business Name', 'identifier' => 'business_name', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Physical Address', 'identifier' => 'physical_address', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Phone Number', 'identifier' => 'phone_number', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Fax Number', 'identifier' => 'fax_number', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Payment Method', 'identifier' => 'payment_method', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Ship From Location', 'identifier' => 'ship_from_location', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Payment Method for Seller’s Fees', 'identifier' => 'payment_method_fees', 'data_type' => 'string', 'is_active' => true],
            [
                'name' => 'Private or Business Seller',
                'identifier' => 'seller_type',
                'data_type' => 'dropdown',
                'is_active' => true,
                'dropdown_values' => json_encode(['Private', 'Business']), // Dropdown options
            ],
            ['name' => 'FFL License Number', 'identifier' => 'ffl_license_number', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Copy of FFL License', 'identifier' => 'ffl_license_copy', 'data_type' => 'file', 'is_active' => true],
            ['name' => 'Company Name', 'identifier' => 'company_name', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Contact Name', 'identifier' => 'contact_name', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Business Address', 'identifier' => 'business_address', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Business Hours', 'identifier' => 'business_hours', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Import/Export', 'identifier' => 'import_export', 'data_type' => 'boolean', 'is_active' => true],
            ['name' => 'Transfer Fee Information', 'identifier' => 'transfer_fee_info', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Other Comments for Profile', 'identifier' => 'other_comments', 'data_type' => 'string', 'is_active' => true],
            ['name' => 'Comment for Our Review', 'identifier' => 'review_comment', 'data_type' => 'string', 'is_active' => true],
        ];

        // Insert the keys into `user_tier_keys`
        foreach ($keys as $key) {
            $insertedKeys[$key['identifier']] = UserTierKey::create($key);
        }

        // Fetch tier IDs
        $buyerTierId = Tier::where('name', 'Buyer')->value('id');
        $sellerTierId = Tier::where('name', 'Seller')->value('id');
        $fflDealerTierId = Tier::where('name', 'FFL Dealer')->value('id');

        // Define the keys required for each tier in the pivot table
        $tierKeyRequirements = [
            // Buyer tier requirements
            $buyerTierId => [
                'first_name', 'last_name', 'confirm_over_18', 'physical_address', 'phone_number', 'payment_method',
                'sales_tax_exemption', // Parent key to show conditional fields
            ],
            // Seller tier requirements
            $sellerTierId => [
                'first_name', 'last_name', 'confirm_over_18', 'physical_address', 'phone_number', 'payment_method',
                'ship_from_location', 'payment_method_fees', 'seller_type', 'sales_tax_exemption', // Include sales tax exemption
            ],
            // FFL Dealer tier requirements
            $fflDealerTierId => [
                'first_name', 'last_name', 'confirm_over_18', 'physical_address', 'phone_number', 'payment_method',
                'ffl_license_number', 'ffl_license_copy', 'company_name', 'contact_name', 'business_address',
                'business_hours', 'import_export', 'transfer_fee_info', 'sales_tax_exemption', // Include sales tax exemption
            ],
        ];

        // Insert into `tier_key_requirements`
        foreach ($tierKeyRequirements as $tierId => $keys) {
            foreach ($keys as $identifier) {
                DB::table('tier_key_requirements')->insert([
                    'tier_id' => $tierId,
                    'user_tier_key_id' => $insertedKeys[$identifier]->id,
                    'is_required' => true,
                ]);
            }
        }
    }
}
