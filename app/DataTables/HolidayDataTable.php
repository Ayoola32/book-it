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
    protected bool $isAdmin;

    public function __construct()
    {
        $this->isAdmin = auth('admin')->check();
    }
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

        $dataTable = (new EloquentDataTable($query))->addIndexColumn();

        // Add name column only for admin
        if ($this->isAdmin) {
            $dataTable->addColumn('employee_id', function ($query) {
                return '<span>' . $query->employee->user->name . '</span>';
            });
        }

        $dataTable->editColumn('start_date', function ($query) {
            return $query->start_date->format('d-m-Y'); // or 'd/m/Y' or 'M j, Y'
        });

        $dataTable->editColumn('end_date', function ($query) {
            return $query->end_date->format('d-m-Y');
        });


        $dataTable->addColumn('status', function ($query) use ($statusColors) {
            $status = $query->status;
            $color = $statusColors[$status] ?? '#7f8c8d';
            return '<span class="badge px-2 py-1" style="background-color: ' . $color . '; color: white;">' . $status . '</span>';
        });

        $dataTable->addColumn('total_days', function ($query) {
            return $query->total_days . ' day' . ($query->total_days > 1 ? 's' : '');
        });

        // Add action column only for admin
        if ($this->isAdmin) {
            $dataTable->addColumn('action', function ($query) {
                $approved = $query->status === 'approved' ? 'selected' : '';
                $pending = $query->status === 'pending' ? 'selected' : '';
                $rejected = $query->status === 'rejected' ? 'selected' : '';

                return '
                    <select class="form-control form-control-sm status-select" data-id="' . $query->id . '" data-value="' . $query->status . '">
                        <option value="approved" ' . $approved . '>Approve</option>
                        <option value="pending" ' . $pending . '>Pending</option>
                        <option value="rejected" ' . $rejected . '>Reject</option>
                    </select>
                ';
            });
        }

        // Add delete btn foe only employees
        if (!$this->isAdmin) {
            $dataTable->addColumn('action-btn', function ($query) {
                return '
                    <a href="' . route('employee.holiday.destroy', $query->id) . '" class="btn-sm text-red delete-item">
                        <i class="ti ti-trash"></i>
                    </a>
                ';
            }); 
        } 

        $columns = ['status', 'total_days', 'action-btn'];
        if ($this->isAdmin) {
            $columns[] = 'employee_id';
            $columns[] = 'action';
        }

        return $dataTable->rawColumns($columns)->setRowId('id');
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
        $columns = [
            Column::computed('DT_RowIndex')->title('#')->width(30)->addClass('text-center'),
            Column::make('start_date')->title('Start Date'),
            Column::make('end_date')->title('End Date'),
            Column::make('total_days')->title('Days Booked'),
            Column::make('reason')->title('Reason'),
            Column::make('status')->title('Status')->width(60),
        ];

        if ($this->isAdmin) {
            array_splice($columns, 1, 0, [
                Column::make('employee_id')->title('Full Name'),
            ]);

            $columns[] = Column::make('feedback')->title('Feedback');
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(160)
                ->addClass('text-center');
        }

        if (!$this->isAdmin) {
            $columns[] = Column::computed('action-btn')
                ->width(160)
                ->addClass('text-center');
        }


        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Holiday_' . date('YmdHis');
    }
}
