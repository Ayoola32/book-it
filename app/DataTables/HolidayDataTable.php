<?php

namespace App\DataTables;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HolidayDataTable extends DataTable
{
    protected ?int $employeeId = null;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', 'holiday.action')
            ->setRowId('id');
    }

    /**
     * Set the employee ID for filtering appointments.
     *
     * @param int $employeeId
     * @return static
     */
    public function forEmployee(int $employeeId): static
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Holiday $model): QueryBuilder
    {
        $query = $model->newQuery();

        if ($this->employeeId) {
            $query->where('employee_id', $this->employeeId);
        }

        return $query;    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('holiday-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    // ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width(30)->addClass('text-center'),
            Column::make('start_date')->title('Start Date'),
            Column::make('end_date')->title('End Date'),
            // Column::make('hours')->title('Hours'),
            Column::make('reason')->title('Reason'),
            Column::make('feedback')->title('Feedback'),
            // Column::make('description')->title('Description'),
            Column::make('status')->title('Status')->width(60),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(160)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Holiday_' . date('YmdHis');
    }
}
