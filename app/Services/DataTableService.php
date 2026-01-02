<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

/**
 * DataTables Service
 * Provides standardized DataTables implementation across the application
 */
class DataTableService
{
    /**
     * Default configuration for all DataTables
     * 
     * @return array
     */
    public static function getDefaultConfig()
    {
        return [
            'processing' => true,
            'serverSide' => true,
            'responsive' => true,
            'pageLength' => 25,
            'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            'language' => [
                'processing' => '<i class="fa fa-spinner fa-spin fa-3x text-primary"></i>',
                'search' => "_INPUT_",
                'searchPlaceholder' => "Search...",
                'lengthMenu' => "Show _MENU_ entries",
                'emptyTable' => "No data available in table",
                'zeroRecords' => "No matching records found",
                'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
                'infoEmpty' => "Showing 0 to 0 of 0 entries",
                'infoFiltered' => "(filtered from _MAX_ total entries)",
                'paginate' => [
                    'first' => "First",
                    'last' => "Last",
                    'next' => "Next",
                    'previous' => "Previous"
                ]
            ],
            'dom' => '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        ];
    }

    /**
     * Build DataTable from eloquent query
     *
     * @param mixed $query - Eloquent query or collection
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public static function of($query)
    {
        return DataTables::of($query);
    }

    /**
     * Build DataTable from eloquent model
     *
     * @param mixed $query - Eloquent query builder
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public static function eloquent($query)
    {
        return DataTables::eloquent($query);
    }

    /**
     * Create a standard status pill column
     *
     * @param string $field - The field name containing status value
     * @param array $statusMap - Map of status values to labels and classes
     * @return \Closure
     */
    public static function statusColumn($field = 'Status', array $statusMap = [])
    {
        $defaultStatusMap = [
            '1' => ['label' => 'Active', 'class' => 'c-pill--success'],
            '0' => ['label' => 'Inactive', 'class' => 'c-pill--warning'],
            '2' => ['label' => 'Leased', 'class' => 'c-pill--danger'],
        ];

        $statusMap = array_merge($defaultStatusMap, $statusMap);

        return function ($row) use ($field, $statusMap) {
            $value = data_get($row, $field, 'unknown');
            $config = $statusMap[$value] ?? ['label' => 'Unknown', 'class' => ''];
            
            return '<a href="javascript:void(0)" class="c-pill ' . $config['class'] . '">' 
                   . $config['label'] . '</a>';
        };
    }

    /**
     * Create a standard action buttons column
     *
     * @param array $actions - Array of actions with routes
     * @param \Closure|null $permissionCallback - Permission check callback
     * @return \Closure
     */
    public static function actionColumn(array $actions, $permissionCallback = null)
    {
        return function ($row) use ($actions, $permissionCallback) {
            $html = '<div class="table-actions-icons">';

            foreach ($actions as $action => $config) {
                // Check permission if callback is provided
                if ($permissionCallback && !$permissionCallback($action, $row)) {
                    continue;
                }

                $url = $config['route'] ?? '#';
                $icon = $config['icon'] ?? 'fa-edit';
                $class = $config['class'] ?? 'edit-icon';
                $dataAttrs = $config['data'] ?? [];
                
                // Build data attributes
                $dataAttrString = '';
                foreach ($dataAttrs as $key => $value) {
                    $dataAttrString .= sprintf(' data-%s="%s"', $key, is_callable($value) ? $value($row) : $value);
                }

                if (isset($config['delete']) && $config['delete'] === true) {
                    $html .= sprintf(
                        '<a href="javascript:void(0)" class="%s deleteRenter" data-url="%s" data-id="%s"><i class="fa-solid %s px-2 py-2 border"></i></a>',
                        $class,
                        $url,
                        $row->Id ?? $row->id,
                        $icon
                    );
                } else {
                    $html .= sprintf(
                        '<a href="%s" class="%s"%s><i class="fa-solid %s px-2 py-2 border"></i></a>',
                        $url,
                        $class,
                        $dataAttrString,
                        $icon
                    );
                }
            }

            $html .= '</div>';
            return $html;
        };
    }

    /**
     * Create a column that safely displays a value or a default
     *
     * @param string|\Closure $field - Field name or closure
     * @param string $default - Default value if field is empty
     * @return \Closure
     */
    public static function safeColumn($field, $default = '-')
    {
        return function ($row) use ($field, $default) {
            if (is_callable($field)) {
                $value = $field($row);
            } else {
                $value = data_get($row, $field);
            }
            
            return !empty($value) ? e($value) : $default;
        };
    }

    /**
     * Create a column with a link
     *
     * @param string $field - Field name to display
     * @param string|\Closure $url - URL or closure returning URL
     * @param array $options - Additional options
     * @return \Closure
     */
    public static function linkColumn($field, $url, array $options = [])
    {
        return function ($row) use ($field, $url, $options) {
            $value = data_get($row, $field, $options['default'] ?? '-');
            
            $href = is_callable($url) ? $url($row) : $url;
            $class = $options['class'] ?? '';
            $target = $options['target'] ?? '';
            
            return sprintf(
                '<a href="%s" class="%s" %s>%s</a>',
                e($href),
                e($class),
                $target ? 'target="' . e($target) . '"' : '',
                e($value)
            );
        };
    }

    /**
     * Create a date column with formatting
     *
     * @param string $field - Field name
     * @param string $format - Date format (default: 'd M Y, h:i A')
     * @param string $default - Default value if date is null
     * @return \Closure
     */
    public static function dateColumn($field, $format = 'd M Y, h:i A', $default = '-')
    {
        return function ($row) use ($field, $format, $default) {
            $value = data_get($row, $field);
            
            if (empty($value)) {
                return $default;
            }
            
            try {
                $date = \Carbon\Carbon::parse($value);
                return $date->format($format);
            } catch (\Exception $e) {
                return $default;
            }
        };
    }

    /**
     * Create a boolean column with Yes/No badges
     *
     * @param string $field - Field name
     * @param array $config - Configuration for Yes/No display
     * @return \Closure
     */
    public static function booleanColumn($field, array $config = [])
    {
        $defaultConfig = [
            'true' => ['label' => 'Yes', 'class' => 'badge-success'],
            'false' => ['label' => 'No', 'class' => 'badge-danger'],
        ];

        $config = array_merge($defaultConfig, $config);

        return function ($row) use ($field, $config) {
            $value = data_get($row, $field);
            $key = $value ? 'true' : 'false';
            $display = $config[$key];
            
            return sprintf(
                '<span class="badge %s">%s</span>',
                $display['class'],
                $display['label']
            );
        };
    }

    /**
     * Create a column with custom HTML
     *
     * @param \Closure $callback - Callback function to generate HTML
     * @return \Closure
     */
    public static function customColumn(\Closure $callback)
    {
        return $callback;
    }

    /**
     * Add index column to DataTable
     *
     * @param \Yajra\DataTables\DataTableAbstract $dataTable
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public static function addIndexColumn($dataTable)
    {
        return $dataTable->addIndexColumn();
    }

    /**
     * Make the DataTable response
     *
     * @param \Yajra\DataTables\DataTableAbstract $dataTable
     * @param array $rawColumns - Columns to render as raw HTML
     * @return mixed
     */
    public static function make($dataTable, array $rawColumns = [])
    {
        return $dataTable->rawColumns($rawColumns)->make(true);
    }
}
