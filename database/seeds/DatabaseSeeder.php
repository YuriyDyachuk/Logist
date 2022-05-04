<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TransportCategoryTableSeeder::class);
        $this->call(TransportRollingStockTypeTableSeeder::class);

        $this->call(PaymentsTypesTableSeeder::class);
        $this->call(SpecializationsTableSeeder::class);
        $this->call(SpecializationRoleTableSeeder::class);

        $this->call(DocumentsTypesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(DocumentRoleTableSeeder::class);
        $this->call(DocumentsFormsTableSeeder::class);
        $this->call(DocumentsFormsFieldsTableSeeder::class);
        $this->call(DocumentsItemsTableSeeder::class);

        $this->call(AdminUsersTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionPositionTableSeeder::class);
        $this->call(OrderInnerIdSeeder::class);
        $this->call(InstructionTableSeeder::class);

        $this->call(OrderPaymentTermsTableSeeder::class);
        $this->call(OrderPaymentTypesTableSeeder::class);
        $this->call(InstructionTableSeeder::class);
//        $this->call(LtmTranslationsTableSeeder::class);
        $this->call(CargoAttrTableSeeder::class);
        $this->call(MailerPermissionsSeeder::class);
        $this->call(ExpensesTableSeeder::class);
    }
}
