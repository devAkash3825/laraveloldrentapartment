<?php
$id = 2584;
try {
    $p = App\Models\PropertyInfo::where('Id', $id)
        ->with(['propertyAdditionalInfo', 'communitydescription'])
        ->first();
    
    if (!$p) {
        echo "Property $id NOT Found\n";
        exit;
    }
    echo "Property Found\n";
    echo 'AddInfo: ' . ($p->propertyAdditionalInfo ? 'Found' : 'Null') . "\n";
    echo 'CommDesc: ' . ($p->communitydescription ? 'Found' : 'Null') . "\n";
    
    // Check if relationships can be accessed without error
    // Emulate what's in blade
    try {
        $x = $p->propertyAdditionalInfo->LeasingTerms ?? 'Empty';
    } catch (\Throwable $e) {
        echo "Error accessing propertyAdditionalInfo->LeasingTerms: " . $e->getMessage() . "\n";
    }
    
    try {
        $y = $p->communitydescription->Description ?? 'Empty';
    } catch (\Throwable $e) {
        echo "Error accessing communitydescription->Description: " . $e->getMessage() . "\n";
    }

} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
