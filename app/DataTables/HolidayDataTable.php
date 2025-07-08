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

        $statusColors = [
            'Pending' => '#f39c12',
            'rejected' => '#ff0000',
            'approved' => '#008000',
        ];
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('employee_id', function ($query) {
                return '
                    <span class="">' . $query->employee->user->name . '</span>

                ';
            })  
            ->addColumn('status', function ($query) use ($statusColors) {
                $status = $query->status;
                $color = $statusColors[$status] ?? '#7f8c8d';

                return '
                    <span class="badge px-2 py-1"
                        style="background-color: ' . $color . '; color: white;">
                        ' . $status . '
                    </span>
                ';
            })
            ->addColumn('action', function ($query) {
                $pending = $query->status == 'pending' ? 'selected' : '';
                $approved = $query->status == 'approved' ? 'selected' : '';
                $rejected = $query->status == 'rejected' ? 'selected' : '';
            
                return '
                    <select class="form-control form-control-sm status-select" data-id="' . $query->id . '" data-value="' . $query->status . '">
                        <option value="approved" ' . $approved . '>Approve</option>
                        <option value="pending" ' . $rejected . '>Reject</option>
                    </select>
                ';
            })              
            ->rawColumns(['employee_id', 'status', 'action'])
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
            Column::make('employee_id')->title('Full Name'),
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
