<?php


function check_user_access($itemType) {
    $user = auth()->user();
    
    switch ($itemType) {
        case 'product':
            return in_array($user->role->role, ['Admin', 'Staff', 'Editor']);
        case 'order':
            return in_array($user->role->role, ['Admin', 'Staff', 'Manager']);
        case 'category':
            return in_array($user->role->role, ['Admin', 'Editor']);
        case 'account':
            return $user->role->role === 'Admin';
        case 'voucher':
            return in_array($user->role->role, ['Admin', 'Staff']);
        case 'report':
            return in_array($user->role->role, ['Admin', 'Manager']);
        case 'payment':
            return in_array($user->role->role, ['Admin', 'Staff']);
        case 'rating':
            return in_array($user->role->role, ['Admin', 'Staff']);
        case 'brand':
            return in_array($user->role->role, ['Admin', 'Editor']);
        default:
            return false;
            break;
    }
}

