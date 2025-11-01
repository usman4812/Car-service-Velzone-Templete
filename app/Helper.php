<?php

function storeFile($file, $path = "storage")
{
    $file = $file;
    $filename = rand() . '.' . $file->getClientOriginalExtension();
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $file->move(public_path($path), $filename);
    return $filename;
}
function requiredField()
{
    return " <span class='text-danger'>*</span>";
}

/**
 * Get permission name for a route
 * Maps route names to their corresponding permission names
 */
function getPermissionForRoute($routeName)
{
    $routePermissionMap = [
        // Dashboard
        'admin.dashboard' => 'view-dashboard',
        'manager.dashboard' => 'view-dashboard',
        'user.dashboard' => 'view-dashboard',
        
        // Job Cards
        'job-card.index' => 'view-job-card',
        'job-card.create' => 'create-job-card',
        'job-card.store' => 'create-job-card',
        'job-card.edit' => 'edit-job-card',
        'job-card.update' => 'edit-job-card',
        'job-card.destroy' => 'delete-job-card',
        'job-card.show' => 'view-job-card',
        'job-card.invoice' => 'view-job-card-invoice',
        'job-card.replacement' => 'view-job-card',
        
        // Customers
        'customers.index' => 'view-customer',
        'customers.create' => 'create-customer',
        'customers.store' => 'create-customer',
        'customers.edit' => 'edit-customer',
        'customers.update' => 'edit-customer',
        'customers.destroy' => 'delete-customer',
        'customers.show' => 'view-customer',
        
        // Categories
        'categories.index' => 'view-category',
        'categories.create' => 'create-category',
        'categories.store' => 'create-category',
        'categories.edit' => 'edit-category',
        'categories.update' => 'edit-category',
        'categories.destroy' => 'delete-category',
        'categories.show' => 'view-category',
        
        // Sub Categories
        'sub-categories.index' => 'view-sub-category',
        'sub-categories.create' => 'create-sub-category',
        'sub-categories.store' => 'create-sub-category',
        'sub-categories.edit' => 'edit-sub-category',
        'sub-categories.update' => 'edit-sub-category',
        'sub-categories.destroy' => 'delete-sub-category',
        'sub-categories.show' => 'view-sub-category',
        
        // Car Manufactures
        'car-manufactures.index' => 'view-car-manufacture',
        'car-manufactures.create' => 'create-car-manufacture',
        'car-manufactures.store' => 'create-car-manufacture',
        'car-manufactures.edit' => 'edit-car-manufacture',
        'car-manufactures.update' => 'edit-car-manufacture',
        'car-manufactures.destroy' => 'delete-car-manufacture',
        'car-manufactures.show' => 'view-car-manufacture',
        
        // Blog
        'blog.index' => 'view-blog',
        'blog.create' => 'create-blog',
        'blog.store' => 'create-blog',
        'blog.edit' => 'edit-blog',
        'blog.update' => 'edit-blog',
        'blog.destroy' => 'delete-blog',
        'blog.show' => 'view-blog',
        
        // Products
        'products.index' => 'view-product',
        'products.create' => 'create-product',
        'products.store' => 'create-product',
        'products.edit' => 'edit-product',
        'products.update' => 'edit-product',
        'products.destroy' => 'delete-product',
        'products.show' => 'view-product',
        
        // Reports
        'reports.index' => 'view-report',
        'reports.create' => 'view-report',
        'reports.store' => 'view-report',
        'reports.edit' => 'view-report',
        'reports.update' => 'view-report',
        'reports.destroy' => 'view-report',
        'reports.show' => 'view-report',
        
        // Replacements
        'replacements.index' => 'view-replacement',
        'replacements.create' => 'create-replacement',
        'replacements.store' => 'create-replacement',
        'replacements.edit' => 'edit-replacement',
        'replacements.update' => 'edit-replacement',
        'replacements.destroy' => 'delete-replacement',
        'replacements.show' => 'view-replacement',
        
        // Contacts
        'contacts.index' => 'view-contact',
        'contacts.create' => 'create-contact',
        'contacts.store' => 'create-contact',
        'contacts.edit' => 'edit-contact',
        'contacts.update' => 'edit-contact',
        'contacts.destroy' => 'delete-contact',
        'contacts.show' => 'view-contact',
        
        // Services
        'services.index' => 'view-service',
        'services.create' => 'create-service',
        'services.store' => 'create-service',
        'services.edit' => 'edit-service',
        'services.update' => 'edit-service',
        'services.destroy' => 'delete-service',
        'services.show' => 'view-service',
        
        // Workers
        'workers.index' => 'view-worker',
        'workers.create' => 'create-worker',
        'workers.store' => 'create-worker',
        'workers.edit' => 'edit-worker',
        'workers.update' => 'edit-worker',
        'workers.destroy' => 'delete-worker',
        'workers.show' => 'view-worker',
        
        // Works
        'works.index' => 'view-work',
        'works.create' => 'create-work',
        'works.store' => 'create-work',
        'works.edit' => 'edit-work',
        'works.update' => 'edit-work',
        'works.destroy' => 'delete-work',
        'works.show' => 'view-work',
        
        // Sales Persons
        'sales-persons.index' => 'view-sales-person',
        'sales-persons.create' => 'create-sales-person',
        'sales-persons.store' => 'create-sales-person',
        'sales-persons.edit' => 'edit-sales-person',
        'sales-persons.update' => 'edit-sales-person',
        'sales-persons.destroy' => 'delete-sales-person',
        'sales-persons.show' => 'view-sales-person',
        
        // Users
        'users.index' => 'view-user',
        'users.create' => 'create-user',
        'users.store' => 'create-user',
        'users.edit' => 'edit-user',
        'users.update' => 'edit-user',
        'users.destroy' => 'delete-user',
        'users.show' => 'view-user',
        
        // Roles
        'roles.index' => 'view-role',
        'roles.create' => 'create-role',
        'roles.store' => 'create-role',
        'roles.edit' => 'edit-role',
        'roles.update' => 'edit-role',
        'roles.destroy' => 'delete-role',
        'roles.show' => 'view-role',
        
        // Permissions
        'permissions.index' => 'view-permission',
        'permissions.create' => 'view-permission',
        'permissions.store' => 'view-permission',
        'permissions.edit' => 'view-permission',
        'permissions.update' => 'view-permission',
        'permissions.destroy' => 'view-permission',
        'permissions.show' => 'view-permission',
        
        // Making Quotation
        'making-quotation.index' => 'view-making-quotation',
        'making-quotation.create' => 'create-making-quotation',
        'making-quotation.store' => 'create-making-quotation',
        'making-quotation.edit' => 'edit-making-quotation',
        'making-quotation.update' => 'edit-making-quotation',
        'making-quotation.destroy' => 'delete-making-quotation',
        'making-quotation.show' => 'view-making-quotation',
    ];
    
    return $routePermissionMap[$routeName] ?? null;
}

/**
 * Check if user can access a route
 */
function userCanAccessRoute($routeName)
{
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return false;
    }
    
    $user = \Illuminate\Support\Facades\Auth::user();
    
    if (!$user) {
        return false;
    }
    
    // Admin has access to everything
    if ($user->hasRole('admin')) {
        return true;
    }
    
    $permission = getPermissionForRoute($routeName);
    
    if (!$permission) {
        // If no permission mapping exists, allow access (backward compatibility)
        return true;
    }
    
    return $user->can($permission);
}

/**
 * Check if user has any of the given permissions
 */
function userCanAccessAny($permissions)
{
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return false;
    }
    
    $user = \Illuminate\Support\Facades\Auth::user();
    
    if (!$user) {
        return false;
    }
    
    // Admin has access to everything
    if ($user->hasRole('admin')) {
        return true;
    }
    
    foreach ($permissions as $permission) {
        if ($user->can($permission)) {
            return true;
        }
    }
    
    return false;
}

/**
 * Generate action buttons (Edit/Delete) with permission checks
 */
function generateActionButtons($routeName, $id, $editPermission = null, $deletePermission = null)
{
    $user = \Illuminate\Support\Facades\Auth::user();
    
    if (!$user) {
        return '<span class="text-muted">No actions</span>';
    }
    
    // If permissions not specified, derive from route name
    if (!$editPermission) {
        $editPermission = str_replace('-', '-', $routeName) . '-edit';
        // Convert route name to permission (e.g., 'customers' -> 'edit-customer')
        $editPermission = 'edit-' . str_replace('s', '', rtrim($routeName, 's'));
    }
    
    if (!$deletePermission) {
        $deletePermission = 'delete-' . str_replace('s', '', rtrim($routeName, 's'));
    }
    
    $canEdit = $user->hasRole('admin') || $user->can($editPermission);
    $canDelete = $user->hasRole('admin') || $user->can($deletePermission);
    
    if (!$canEdit && !$canDelete) {
        return '<span class="text-muted">No actions available</span>';
    }
    
    $editUrl = route($routeName . '.edit', $id);
    $deleteUrl = route($routeName . '.destroy', $id);
    
    $html = '
    <div class="dropdown d-inline-block">
        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ri-more-fill align-middle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">';
    
    if ($canEdit) {
        $html .= '
            <li>
                <a href="' . $editUrl . '" class="dropdown-item edit-item-btn">
                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                </a>
            </li>';
    }
    
    if ($canDelete) {
        $html .= '
            <li>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="button" class="dropdown-item remove-item-btn show-confirm">
                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                    </button>
                </form>
            </li>';
    }
    
    $html .= '
        </ul>
    </div>';
    
    return $html;
}
