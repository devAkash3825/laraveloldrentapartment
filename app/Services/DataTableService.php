<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminDetail;

/**
 * DataTables Service
 * Provides standardized DataTables implementation across the application
 */
class DataTableService
{
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
     * Create a standard status pill column
     *
     * @param string $field - The field name containing status value
     * @return \Closure
     */
    public static function statusColumn($field = 'Status')
    {
        return function ($row) use ($field) {
            $value = (string) data_get($row, $field, 'unknown');
            
            $config = match ($value) {
                '1' => ['label' => 'Active', 'class' => 'c-pill--success'],
                '0' => ['label' => 'Inactive', 'class' => 'c-pill--warning'],
                '2' => ['label' => 'Leased', 'class' => 'c-pill--danger'],
                default => ['label' => 'Unknown', 'class' => ''],
            };
            
            return '<a href="javascript:void(0)" class="c-pill ' . $config['class'] . '">' 
                   . $config['label'] . '</a>';
        };
    }

    /**
     * Create a standard action buttons column
     *
     * @param array $actions - Array of actions with routes
     * @param string $permissionCategory - Optional category for permission check
     * @return \Closure
     */
    public static function actionColumn(array $actions)
    {
        return function ($row) use ($actions) {
            $user = Auth::guard('admin')->user();
            $html = '<div class="table-actions-icons">';

            foreach ($actions as $type => $config) {
                // Check specific permission if provided
                if (isset($config['permission'])) {
                    if (!$user || !$user->hasPermission($config['permission'])) {
                        continue;
                    }
                }

                $url = isset($config['route']) ? (is_callable($config['route']) ? $config['route']($row) : $config['route']) : 'javascript:void(0)';
                $icon = $config['icon'] ?? null;
                $class = $config['class'] ?? '';
                $label = $config['label'] ?? null;
                $onclick = isset($config['onclick']) ? (is_callable($config['onclick']) ? $config['onclick']($row) : $config['onclick']) : null;
                $onclickHtml = $onclick ? "onclick=\"{$onclick}\"" : "";
                
                $premiumClass = match($type) {
                    'edit' => 'edit-icon-premium',
                    'view' => 'view-icon-premium',
                    'delete' => 'delete-icon-premium',
                    default => ''
                };

                if (isset($config['delete']) && $config['delete'] === true) {
                    $html .= sprintf(
                        '<a href="javascript:void(0)" class="%s action-icon delete-btn %s" data-url="%s" data-id="%s" title="Delete" %s><i class="fa-solid %s"></i></a>',
                        $class,
                        $premiumClass,
                        $url,
                        data_get($row, 'Id') ?? data_get($row, 'id'),
                        $onclickHtml,
                        $icon ?? 'fa-trash'
                    );
                } else if ($label) {
                    $html .= sprintf(
                        '<a href="%s" class="btn btn-sm btn-premium %s %s" title="%s" %s>%s</a>',
                        $url,
                        strpos($class, 'btn-danger') !== false ? 'btn-premium-danger' : 'btn-premium-primary',
                        $class,
                        ucfirst($type),
                        $onclickHtml,
                        e($label)
                    );
                } else {
                    $html .= sprintf(
                        '<a href="%s" class="%s action-icon %s" title="%s" %s><i class="fa-solid %s"></i></a>',
                        $url,
                        $class,
                        $premiumClass,
                        ucfirst($type),
                        $onclickHtml,
                        $icon ?? 'fa-circle-question'
                    );
                }
            }

            $html .= '</div>';
            return $html;
        };
    }

    /**
     * Create a column that safely displays a value or a default
     */
    public static function safeColumn($field, $default = '-')
    {
        return function ($row) use ($field, $default) {
            $value = data_get($row, $field);
            return !empty($value) ? e($value) : $default;
        };
    }

    /**
     * Admin Name helper
     */
    public static function adminColumn($relationField = 'renterinfo.added_by')
    {
        return function ($row) use ($relationField) {
            $adminId = data_get($row, $relationField);
            return $adminId ? AdminDetail::getAdminNameById($adminId) : '-';
        };
    }
}
