<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    /**
     * Map request data to Property model attributes and create a property.
     */
    public function createProperty(array $data, int $organizationId): Property
    {
        $mappedData = $this->mapPropertyData($data);
        $mappedData['organization_id'] = $organizationId;
        
        return Property::create($mappedData);
    }

    /**
     * Map request data to Property model attributes and update a property.
     */
    public function updateProperty(Property $property, array $data): bool
    {
        $mappedData = $this->mapPropertyData($data, $property->address_metadata);
        
        return $property->update($mappedData);
    }

    /**
     * Standardize property data, mapping staff-specific fields to admin fields.
     */
    private function mapPropertyData(array $data, ?array $existingMetadata = []): array
    {
        $mapped = [
            'unit_number' => $data['unit_number'] ?? $data['property_number'] ?? null,
            'street_area' => $data['street_area'] ?? null,
            'locality_village' => $data['locality_village'] ?? 'Default Locality', // Required by admin, default if missing
            'city_town' => $data['city_town'] ?? 'Default City',
            'district' => $data['district'] ?? 'Default District',
            'state' => $data['state'] ?? 'Default State',
            'pincode' => $data['pincode'] ?? $data['pin_code'] ?? null,
            'type' => $data['type'] ?? 'residential',
            'owner_id' => $data['owner_id'] ?? null,
            'resident_id' => $data['resident_id'] ?? null,
        ];

        // Ensure defaults are overridden if empty strings are passed (staff UI might send empty)
        if (empty($mapped['locality_village'])) $mapped['locality_village'] = 'Default Locality';
        if (empty($mapped['city_town'])) $mapped['city_town'] = 'Default City';
        if (empty($mapped['district'])) $mapped['district'] = 'Default District';
        if (empty($mapped['state'])) $mapped['state'] = 'Default State';

        $metadata = $existingMetadata ?? [];

        if (!empty($data['unstructured_data'])) {
            $metadata['additional_info'] = $data['unstructured_data'];
        }

        if (!empty($data['block'])) {
            $metadata['block'] = $data['block'];
        }

        if (!empty($data['building_name'])) {
            $metadata['building_name'] = $data['building_name'];
        }

        $mapped['address_metadata'] = empty($metadata) ? null : $metadata;

        return $mapped;
    }
}
