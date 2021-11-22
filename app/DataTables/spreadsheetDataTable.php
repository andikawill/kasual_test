<?php

namespace App\DataTables;

use App\Models\spreadsheet;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class spreadsheetDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'spreadsheets.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\spreadsheet $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(spreadsheet $model)
    {
        $sheets = Sheets::spreadsheet(config("google.post_spreadsheet_id"))
        ->sheet(config("google.post_sheet_id"))
        ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $data = $posts->sortBy("first_name")->all();

        return $model->hydrate( $data->toArray() );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'first_name',
            'last_name',
            'gender',
            'email',
            'ip_address'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'spreadsheets_datatable_' . time();
    }
}
