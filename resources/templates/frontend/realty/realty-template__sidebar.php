<?php

use Justimmo\Wordpress\Translation\CitynameTranslator;
use Justimmo\Wordpress\Helper\NumberFormatter;

?>

<!-- Basic Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Basic details:', 'jiwp'); ?></h3>

    <ul class="ji-info-list ji-info-list--extended">
        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Realty Number:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php /** @var \Justimmo\Model\Realty $realty */
                echo $realty->getPropertyNumber(); ?>
            </span>
        </li>

        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Country / State:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $realty->getCountry() . ' / ' . $realty->getFederalState(); ?>
            </span>
        </li>

        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Address:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php

                $address_array = array();

                $zipCode =  $realty->getZipCode();

                if (!empty($zipCode)) {
                    $address_array[] = $zipCode;
                }

                $place = CitynameTranslator::translate($realty->getPlace());

                if (!empty($place)) {
                    $address_array[] = $place;
                }

                $street = $realty->getStreet();

                if (!empty($street)) {
                    $address_array[] = $street;
                }

                $houseNumber = $realty->getHouseNumber();

                if (!empty($houseNumber)) {
                    $address_array[] = $houseNumber;
                }

                $stair = $realty->getStair();

                if (!empty($stair)) {
                    $address_array[] = $stair;
                }

                $doorNumber = $realty->getDoorNumber();

                if (!empty($doorNumber)) {
                    $address_array[] = $doorNumber;
                }

                echo implode(', ', $address_array);

                ?>
            </span>
        </li>

        <?php $locality = $realty->getLocality(); ?>
        <?php if (!empty($locality)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Location:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $locality; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $proximity = $realty->getProximity(); ?>
        <?php if (!empty($proximity)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Proximity:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $proximity; ?>
                </span>
            </li>
        <?php endif; ?>

        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Commercial Type:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $realty->getRealtyTypeName(); ?>
            </span>
        </li>

        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Realty Type:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $realty->getSubRealtyTypeName(); ?>
            </span>
        </li>

        <?php $building_age = $realty->getStyleOfBuilding(); ?>
        <?php if (!empty($building_age)) : ?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Building Age:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $building_age; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php $categories = $realty->getCategories(); ?>
        <?php if (!empty($categories)) : ?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Categories:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo implode(', ', $categories); ?>
                </span>
            </li>

        <?php endif; ?>

        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('For:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php

                $is_for_rent = true;

                if ($realty->getMarketingType()['KAUF'] == true) {
                    $is_for_rent = false;
                    _e('Purchase', 'jiwp');
                } else {
                    _e('Rent', 'jiwp');
                }

                ?>
            </span>
        </li>
    </ul>
</section>

<!-- Contact Details -->
<?php $contact = $realty->getContact(); ?>
<?php if (!empty($contact)) : ?>
    <section class="ji-info-section">
        <h2 class="ji-info-section__title"><?php _e('Your Contact Person', 'jiwp'); ?></h2>

        <div class="contact-person">
            <?php $pictures = $contact->getPictures(); ?>
            <?php if (!empty($pictures)) : ?>
                <img src="<?php echo $pictures[0]->getUrl('small'); ?>" class="contact-person__avatar" alt=""/>
            <?php endif; ?>
            <ul class="ji-info-list contact-person__info-list">
                <li class="ji-info">
                    <label class="ji-info__label"><?php _e('Name:', 'jiwp'); ?></label>
                    <span class="ji-info__value">
                        <?php

                        echo $contact->getTitle() . ' '
                             . $contact->getFirstName() . ' '
                             . $contact->getLastName() . ' ';

                        ?>
                    </span>
                </li>

                <?php $contact_email = $contact->getEmail(); ?>
                <?php if (!empty($contact_email)) : ?>
                    <li class="ji-info">
                        <label class="ji-info__label"><?php _e('Email:', 'jiwp'); ?></label>
                        <span class="ji-info__value"><?php echo $contact_email; ?></span>
                    </li>
                <?php endif; ?>

                <?php $contact_phone = $contact->getPhone(); ?>
                <?php if (!empty($contact_phone)) : ?>
                    <li class="ji-info">
                        <label class="ji-info__label"><?php _e('Phone:', 'jiwp'); ?></label>
                        <span class="ji-info__value"><?php echo $contact_phone; ?></span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>

<!-- Surface Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Surface:', 'jiwp'); ?></h3>

    <ul class="ji-info-list ji-info-list--extended">
        <?php $floor_area = $realty->getFloorArea(); ?>
        <?php if (!empty($floor_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Floor Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $floor_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $surface_area = $realty->getSurfaceArea(); ?>
        <?php if (!empty($surface_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Surface Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $surface_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $living_area = $realty->getLivingArea(); ?>
        <?php if (!empty($living_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Living Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $living_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $total_area = $realty->getTotalArea(); ?>
        <?php if (!empty($total_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Total Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $total_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $balcony_area = $realty->getBalconyArea(); ?>
        <?php if (!empty($balcony_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Balcony Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $balcony_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $terrace_area = $realty->getTerraceArea(); ?>
        <?php if (!empty($terrace_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Terrace Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $terrace_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $garden_area = $realty->getGardenArea(); ?>
        <?php if (!empty($garage_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Garden Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $garden_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $cellar_area = $realty->getCellarArea(); ?>
        <?php if (!empty($cellar_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Cellar Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $cellar_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $office_area = $realty->getOfficeArea(); ?>
        <?php if (!empty($office_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Office Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $office_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $storage_area = $realty->getStorageArea(); ?>
        <?php if (!empty($storage_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Storage Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $storage_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $loggia_area = $realty->getLoggiaArea(); ?>
        <?php if (!empty($loggia_area)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Loggia Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $loggia_area . ' m&sup2;'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $garage_area = $realty->getGarageArea(); ?>
        <?php if (!empty($garage_area)) : ?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Garage Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $garage_area . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php $parking_area = $realty->getParkingArea(); ?>
        <?php if (!empty($parking_area)) : ?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Parking Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $parking_area . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php $buildable_area = $realty->getBuildableArea(); ?>
        <?php if (!empty($buildable_area)) : ?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Buildable Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $buildable_area . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

    </ul>
</section>

<!-- Room Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Room Count:', 'jiwp'); ?></h3>

    <ul class="ji-info-list">
        <?php $room_count = $realty->getRoomCount(); ?>
        <?php if (!empty($room_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Rooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $room_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $bathroom_count = $realty->getBathroomCount(); ?>
        <?php if (!empty($bathroom_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Bathrooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $bathroom_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $toiletroom_count = $realty->getToiletRoomCount(); ?>
        <?php if (!empty($toiletroom_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Toilet Rooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $toiletroom_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $balcony_count = $realty->getBalconyCount(); ?>
        <?php if (!empty($balcony_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Balconies:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $balcony_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $terrace_count = $realty->getTerraceCount(); ?>
        <?php if (!empty($terrace_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Terraces:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $terrace_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $loggia_count = $realty->getLoggiaCount(); ?>
        <?php if (!empty($loggia_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Loggias:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $loggia_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $loggia_count = $realty->getLoggiaCount(); ?>
        <?php if (!empty($loggia_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Loggias:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $loggia_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $garage_count = $realty->getGarageCount(); ?>
        <?php if (!empty($garage_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Garages:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $garage_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $parking_count = $realty->getParkingCount(); ?>
        <?php if (!empty($parking_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Parking Spaces:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $parking_count; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $storeroom_count = $realty->getStoreRoomCount(); ?>
        <?php if (!empty($storeroom_count)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Store Rooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $storeroom_count; ?>
                </span>
            </li>
        <?php endif; ?>
    </ul>
</section>

<!-- Equipment Details -->
<?php $equipment_description = $realty->getEquipmentDescription(); ?>
<?php if (!empty($equipment_description)) : ?>
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Equipment Description', 'jiwp'); ?></h3>

    <?php echo $equipment_description; ?>
</section>
<?php endif; ?>

<!-- Price/Costs Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Prices / Costs', 'jiwp'); ?></h3>

    <?php $currency = $realty->getCurrency(); ?>
    <ul class="ji-info-list">
        <?php

        $price_text = '';
        $currency = $realty->getCurrency();
        $marketingType = $realty->getMarketingType();

        if (empty($currency)) {
            $currency = 'EUR';
        }

        if ($marketingType['KAUF'] == true) {
            if (!empty($realty->getPurchasePrice())) {
                $price_text = NumberFormatter::formatCurrency(
                    $realty->getPurchasePrice(),
                    $currency,
                    0
                );
            }
        } else {
            if (!empty($realty->getTotalRent())) {
                $price_text = NumberFormatter::formatCurrency(
                    $realty->getTotalRent(),
                    $currency,
                    0
                );
            }
        }

        ?>

        <?php if (!empty($price_text)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Price:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $price_text; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $commision = $realty->getCommission(); ?>
        <?php if (!empty($commision)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Commission:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $realty->getCommission(); ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $additional_costs = $realty->getAdditionalCosts(); ?>
        <?php if (!empty($additional_costs)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Additional Costs:', 'jiwp'); ?>
                </label>
                <ul>
                    <?php /** @var \Justimmo\Model\AdditionalCosts $additional_cost */ ?>
                    <?php foreach ($additional_costs as $key => $additional_cost) :?>
                        <li>
                            <label class="ji-info__label">
                                <?php echo $additional_cost->getName() . ':'; ?>
                            </label>
                            <span class="ji-info__value">
                                <?php echo money_format("%!i $currency", $additional_cost->getGross()); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php $contract_establishment_costs = $realty->getContractEstablishmentCosts(); ?>
        <?php if (!empty($contract_establishment_costs)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Contract Establishment Costs:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $contract_establishment_costs; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $land_registration_tax = $realty->getLandRegistration(); ?>
        <?php if (!empty($land_registration_tax)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Land Registration Tax:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $land_registration_tax . '%'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $transfer_tax = $realty->getTransferTax(); ?>
        <?php if (!empty($transfer_tax)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Transfer Tax:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $transfer_tax . '%'; ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $additional_charges = $realty->getAdditionalCharges(); ?>
        <?php if (!empty($additional_charges)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Additional Charges:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo money_format("%!i $currency", $additional_charges) ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $yearly_net_earn = $realty->getNetEarningYearly(); ?>
        <?php if (!empty($yearly_net_earn)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Yearly Net Earning:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo money_format("%!i $currency", $yearly_net_earn) ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $building_subsidence = $realty->getBuildingSubsidies(); ?>
        <?php if (!empty($building_subsidence)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Building Subsidence:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo money_format("%!i $currency", $building_subsidence) ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $net_yield = $realty->getYield(); ?>
        <?php if (!empty($net_yield)) : ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Net Yield:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $net_yield . '%'; ?>
                </span>
            </li>
        <?php endif; ?>
    </ul>
</section>

<!-- Energy Efficiency Certificate -->
<?php $energy_pass = $realty->getEnergyPass(); ?>

<?php if (!empty($energy_pass)) :?>
    <section class="ji-info-section">
        <h3 class="ji-info-section__title"><?php _e('Energy Efficiency Certificate', 'jiwp'); ?></h3>

        <ul class="ji-info-list">
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Valid until:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo (string) $energy_pass->getValidUntil(); ?>
                </span>
            </li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Annual Thermal Energy Consumption:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $energy_pass->getThermalHeatRequirementValue(); ?> kWh/m&sup2;a
                    (<?php _e('class', 'jiwp'); ?>
                    <?php echo $energy_pass->getThermalHeatRequirementClass(); ?>)
                </span>
            </li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Energy Efficiency Factor:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $energy_pass->getEnergyEfficiencyFactorValue(); ?>
                    (<?php _e('class', 'jiwp'); ?>
                    <?php echo $energy_pass->getEnergyEfficiencyFactorClass(); ?>)
                </span>
            </li>
        </ul>
    </section>
<?php endif; ?>

<!-- Inquiry Form -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Inquiry Form', 'jiwp'); ?></h3>

    <?php include(Justimmo\Wordpress\Templating::getPath('inquiry-form/_inquiry-form.php')); ?>
</section>
