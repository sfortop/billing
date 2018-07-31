<?php


use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {

        $this->table('account', ['id' => false, 'primary_key' => 'uuid'])
            ->addColumn('uuid', 'string', ['limit' => 36])
            ->addColumn('credential', 'string', ['limit' => 200])
            ->addColumn('amount', 'decimal', ['precision' => 31, 'scale' => 18])
            ->addColumn('currency_code', 'string', ['limit' => 3])
            ->addColumn('date_create', 'datetime')
            ->addColumn('customer', 'string', ['limit' => 36])
            ->addColumn('payment_system', 'string', ['limit' => 200])
            ->addColumn('is_debt_allowed', 'boolean', ['default' => false])
            ->addIndex(['credential', 'currency_code'], ['unique' => true])
            ->create()
        ;

        $this->table('currency', ['id' => false, 'primary_key' => 'code'])
            ->addColumn('code', 'string', ['limit' => 3])
            ->addColumn('fraction', 'integer', ['limit' => 2])
            ->create()
        ;

        $this->table('customer', ['id' => false, 'primary_key' => 'uuid'])
            ->addColumn('uuid', 'string', ['limit' => 36])
            ->addColumn('name', 'string', ['limit' => 200 ])
            ->addColumn('email', 'string', ['limit' => 200 ])
            ->addColumn('pubkey', 'string', ['limit' => 200 ])
            ->addColumn('seckey', 'string', ['limit' => 200 ])
            ->addColumn('customer_pub_key', 'string', ['limit' => 200 ])
            ->addColumn('signature', 'string', ['limit' => 200 ])
            ->addColumn('encoder', 'string', ['limit' => 200 ])
            ->create()
        ;

        $this->table('transaction', ['id' => false, 'primary_key' => 'uuid'])
            ->addColumn('uuid', 'string', ['limit' => 36])
            ->addColumn('debit_account', 'string', ['limit' => 36])
            ->addColumn('credit_account', 'string', ['limit' => 36])
            ->addColumn('amount', 'decimal', ['precision' => 31, 'scale' => 18])
            ->addColumn('currency_code', 'string', ['limit' => 3])
            ->addColumn('comment', 'string', ['limit' => 512])
            ->addColumn('date_create', 'datetime')
            ->addColumn('customer_transaction', 'string', ['limit' => 36])
            ->addColumn('customer', 'string', ['limit' => 36])
            ->addColumn('status_code', 'string', ['limit' => 10])
            ->addIndex(['customer', 'customer_transaction'], ['unique' => true])
            ->create()
        ;

        $this->table('transaction_status', ['id' => false, 'primary_key' => 'code'])
            ->addColumn('name', 'string', ['limit' => 40])
            ->addColumn('code', 'string', ['limit' => 10])
            ->create()
        ;
    }
}
