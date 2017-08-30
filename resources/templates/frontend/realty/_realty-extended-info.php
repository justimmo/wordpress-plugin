<!-- Basic Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Basic details:', 'jiwp'); ?></h3>

    <ul class="ji-info-list ji-info-list--extended">
        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Realty Number:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $realty->getPropertyNumber(); ?>
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

                $addressParts = array();

                $zipCode =  $realty->getZipCode();

                if (!empty($zipCode)) {
                    $addressParts[0] = $zipCode;
                }

                $place = $realty->getPlace();

                if (!empty($place)) {
                    $addressParts[0] .= ($addressParts[0] ? ' ' : '') . $place;
                }

                $street = $realty->getStreet();

                if (!empty($street)) {
                    $addressParts[1] = $street;
                }

                $houseNumber = $realty->getHouseNumber();

                if (!empty($houseNumber)) {
                    $addressParts[1] .= ($addressParts[1] ? ' ' : '') . $houseNumber;
                }

                $stair = $realty->getStair();

                if (!empty($stair)) {
                    $addressParts[1] .= ($addressParts[1] ? '/' : '') . $stair;
                }

                $doorNumber = $realty->getDoorNumber();

                if (!empty($doorNumber)) {
                    $addressParts[1] .= ($addressParts[1] ? '/' : '') . $doorNumber;
                }

                echo implode(', ', $addressParts);
                ?>
            </span>
        </li>

        <?php $locality = $realty->getLocality(); ?>
        <?php if (!empty($locality)): ?>
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
        <?php if (!empty($proximity)): ?>
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
                <?php _e('Realty Type:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $realty->getRealtyTypeName(); ?>
            </span>
        </li>

        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e('Realty Subtype:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $realty->getSubRealtyTypeName(); ?>
            </span>
        </li>

        <?php $building_age = $realty->getStyleOfBuilding(); ?>
        <?php if (!empty($building_age)): ?>

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
        <?php if (!empty($categories)): ?>
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
<?php if (!empty($contact)): ?>
    <section class="ji-info-section">
        <h2 class="ji-info-section__title"><?php _e('Your Contact Person', 'jiwp'); ?></h2>
        <div class="contact-person">
            <?php $pictures = $contact->getPictures(); ?>
            <?php if (!empty($pictures)): ?>
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
                <?php if (!empty($contact_email)): ?>
                    <li class="ji-info">
                        <label class="ji-info__label"><?php _e('Email:', 'jiwp'); ?></label>
                        <span class="ji-info__value"><?php echo $contact_email; ?></span>
                    </li>
                <?php endif; ?>

                <?php $contact_phone = $contact->getPhone(); ?>
                <?php if (!empty($contact_phone)): ?>
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

        <?php if ($floor_area = $realty->getFloorArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Floor Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($floor_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($surface_area = $realty->getSurfaceArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Surface Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($surface_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($living_area = $realty->getLivingArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Living Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($living_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($total_area = $realty->getTotalArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Total Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($total_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($balcony_area = $realty->getBalconyArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Balcony Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($balcony_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($terrace_area = $realty->getTerraceArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Terrace Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($terrace_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($garden_area = $realty->getGardenArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Garden Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($garden_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($cellar_area = $realty->getCellarArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Cellar Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($cellar_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($office_area = $realty->getOfficeArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Office Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($office_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($storage_area = $realty->getStorageArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Storage Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($storage_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($loggia_area = $realty->getLoggiaArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Loggia Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($loggia_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($garage_area = $realty->getGarageArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Garage Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($garage_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($parking_area = $realty->getParkingArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Parking Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($parking_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($buildable_area = $realty->getBuildableArea()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Buildable Area:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($buildable_area) . ' m&sup2;'; ?>
                </span>
            </li>

        <?php endif; ?>

    </ul>
</section>

<!-- Room Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Room Count:', 'jiwp'); ?></h3>

    <ul class="ji-info-list">

        <?php if ($room_count = $realty->getRoomCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Rooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($room_count); ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($bathroom_count = $realty->getBathroomCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Bathrooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $bathroom_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($toiletroom_count = $realty->getToiletRoomCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Toilet Rooms:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $toiletroom_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($balcony_count = $realty->getBalconyCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Balconies:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $balcony_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($terrace_count = $realty->getTerraceCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Terraces:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $terrace_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($loggia_count = $realty->getLoggiaCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Loggias:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $loggia_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($garage_count = $realty->getGarageCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Garages:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $garage_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($parking_count = $realty->getParkingCount()) :?>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Parking Spaces:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $parking_count; ?>
                </span>
            </li>

        <?php endif; ?>

        <?php if ($storeroom_count = $realty->getStoreRoomCount()) :?>

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
<?php if ($realty->getEquipmentDescription()): ?>
    <section class="ji-info-section">
        <h3 class="ji-info-section__title"><?php _e('Equipment Description', 'jiwp'); ?></h3>
        <?php echo $realty->getEquipmentDescription(); ?>
    </section>
<?php endif; ?>

<!-- Price/Costs Details -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Prices / Costs', 'jiwp'); ?></h3>

    <ul class="ji-info-list">
        <?php $currency = empty($realty->getCurrency()) ? 'EUR' : $realty->getCurrency(); ?>
        <?php $vat = 0; ?>

		<?php if ($realty->getMarketingType()['KAUF'] == true): ?>
            <li class="ji-info">
                <label class="ji-info__label">
				    <?php _e('Purchase Price:', 'jiwp'); ?>
				</label>
				<span class="ji-info__value">
                    <?php if ($realty->getPurchasePrice()): ?>
					    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($realty->getPurchasePrice(), $currency, 0); ?>
                    <?php else: ?>
                        <?php _e('on request', 'jiwp'); ?>
                    <?php endif; ?>
                </span>
            </li>
        <?php else: ?>
            <label class="ji-info__label">
                <?php _e('Rent:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php if ($realty->getRentNet()): ?>
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($realty->getRentNet(), $currency, 0); ?>
                    <?php $vat += $realty->getRentGross() - $realty->getRentNet(); ?>
                <?php else: ?>
                    <?php _e('on request', 'jiwp'); ?>
                <?php endif; ?>
            </span><br />
        <?php endif; ?>

        <?php $additional_costs = $realty->getAdditionalCosts(); ?>
        <?php $optionalCosts = 0; ?>

        <?php if (!empty($additional_costs)): ?>
            <?php foreach ($additional_costs as $key => $additional_cost) :?>
                <?php if ($additional_cost->getOptional()): ?>
                    <?php $optionalCosts++; ?>
                <?php else: ?>
                    <label class="ji-info__label">
                        <?php echo $additional_cost->getName() . ':'; ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($additional_cost->getNet(), $currency, 0); ?>
                        <?php $vat += $additional_cost->getGross() - $additional_cost->getNet(); ?>
                    </span><br />
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($vat): ?>
            <label class="ji-info__label">
                <?php _e('VAT:', 'jiwp'); ?>
            </label>
            <span class="ji-info__value">
                <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($vat, $currency, 0); ?>
            </span><br />
        <?php endif; ?>

        <?php $monthlyCosts = $realty->getMonthlyCosts() ? $realty->getMonthlyCosts() : $realty->getTotalRent(); ?>

        <?php if ($monthlyCosts): ?>
            <li class="ji-info"></li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Monthly Costs:', 'jiwp'); ?>
                </label>

                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($monthlyCosts, $currency, 0); ?>
                </span>
            </li>
        <?php endif; ?>
    </ul>

    <?php if ($optionalCosts > 0): ?>
        <h3 class="ji-info-section__title"><?php _e('Optional costs', 'jiwp'); ?></h3>

        <ul class="ji-info-list">
            <?php foreach ($additional_costs as $key => $additional_cost) :?>
                <?php if ($additional_cost->getOptional()): ?>
                    <li class="ji-info">
                        <label class="ji-info__label">
                            <?php echo $additional_cost->getName() . ':'; ?>
                        </label>
                        <span class="ji-info__value">
                            <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($additional_cost->getGross(), $currency, 0); ?>
                        </span>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php $commision = $realty->getCommission(); ?>
    <?php $contract_establishment_costs = $realty->getContractEstablishmentCosts(); ?>
    <?php $land_registration_tax = $realty->getLandRegistration(); ?>
    <?php $transfer_tax = $realty->getTransferTax(); ?>
    <?php $transfer_fee = $realty->getCompensation(); ?>
    <?php $surety = $realty->getSurety(); ?>
    <?php $financial_contribution = $realty->getFinancialContribution(); ?>
    <?php $infrastructure_provision = $realty->getInfrastructureProvision(); ?>

    <?php if (!empty($commision) || !empty($transfer_fee) || !empty($surety) || !empty($financial_contribution) || !empty($contract_establishment_costs) || !empty($land_registration_tax) || !empty($transfer_tax) || !empty($infrastructure_provision)): ?>
        <h3 class="ji-info-section__title"><?php _e('Ancillary expenses', 'jiwp'); ?></h3>

        <ul class="ji-info-list">
            <?php if (!empty($commision)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Commission:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo $realty->getCommission(); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($contract_establishment_costs)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Contract Establishment Costs:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo $contract_establishment_costs; ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($land_registration_tax)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Land Registration Tax:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatPercent($land_registration_tax / 100); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($transfer_fee)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Transfer fee:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency( $transfer_fee, $currency, 0); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($surety)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Surety:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency( $surety, $currency, 0); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($financial_contribution)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Financial contribution:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency( $financial_contribution, $currency, 0); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($transfer_tax)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Transfer Tax:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatPercent( $transfer_tax/100); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($infrastructure_provision)): ?>
                <li class="ji-info">
                    <label class="ji-info__label">
                        <?php _e('Infrastructure Provision:', 'jiwp'); ?>
                    </label>
                    <span class="ji-info__value">
                        <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($infrastructure_provision, $currency, 0) ?>
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>

    <ul class="ji-info-list">
        <?php $building_subsidence = $realty->getBuildingSubsidies(); ?>
        <?php if (!empty($building_subsidence)): ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Building Subsidence:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($building_subsidence, $currency, 0) ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $yearly_net_earn = $realty->getNetEarningYearly(); ?>
        <?php if (!empty($yearly_net_earn)): ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Yearly Net Earning:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($yearly_net_earn, $currency, 0) ?>
                </span>
            </li>
        <?php endif; ?>

        <?php $net_yield = $realty->getYield(); ?>
        <?php if (!empty($net_yield)): ?>
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Net Yield:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo Justimmo\Wordpress\Helper\NumberFormatter::formatPercent($net_yield / 100); ?>
                </span>
            </li>
        <?php endif; ?>
    </ul>
</section>

<!-- Energy Efficiency Certificate -->
<?php $energy_pass = $realty->getEnergyPass(); ?>

<?php if (!empty($energy_pass)): ?>
    <section class="ji-info-section">
        <h3 class="ji-info-section__title"><?php _e('Energy Efficiency Certificate', 'jiwp'); ?></h3>
        <ul class="ji-info-list">
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Valid until:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $energy_pass->getValidUntil(); ?>
                </span>
            </li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Annual Thermal Energy Consumption:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $energy_pass->getThermalHeatRequirementValue(); ?> kWh/m&sup2;a
                    (<?php _e('Class', 'jiwp'); ?>
                    <?php echo $energy_pass->getThermalHeatRequirementClass(); ?>)
                </span>
            </li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e('Energy Efficiency Factor:', 'jiwp'); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $energy_pass->getEnergyEfficiencyFactorValue(); ?>
                    (<?php _e('Class', 'jiwp'); ?>
                    <?php echo $energy_pass->getEnergyEfficiencyFactorClass(); ?>)
                </span>
            </li>
        </ul>
    </section>
<?php endif; ?>

<!-- Description Text -->
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Description', 'jiwp'); ?></h3>
    <?php echo $realty->getDescription(); ?>
</section>

<!-- Other Information Text -->
<?php $other_information = $realty->getOtherInformation(); ?>
<?php if (!empty($other_information)): ?>
    <section class="ji-info-section">
        <h3 class="ji-info-section__title"><?php _e('Other Information', 'jiwp'); ?></h3>
        <?php echo $other_information; ?>
    </section>
<?php endif; ?>

<!-- Documents -->
<section class="ji-info-section">
    <?php $attachments = $realty->getDocuments(); ?>
    <?php if (!empty($attachments)): ?>
        <ul class="ji-info-list ji-info-list--extended">
        <?php foreach ($attachments as $attachment): ?>
            <li class="ji-info-list__item">
                <a href="<?php echo $attachment->getUrl(); ?>">
                    <?php echo $attachment->getTitle(); ?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<!-- Map -->
<?php $lat = $realty->getLatitudePrecise(); ?>
<?php $lng = $realty->getLongitudePrecise(); ?>
<?php if ($lat && $lng && get_option(JIWP_GOOGLE_API_KEY_OPTION, '')): ?>
<section class="ji-info-section">
    <h3 class="ji-info-section__title"><?php _e('Location', 'jiwp'); ?></h3>
    <div class="jiwp-map"></div>
    <script>
        var RealtyData = {
            position: {
                lat: <?php echo $lat; ?>,
                lng: <?php echo $lng; ?>
            },
            title: <?php echo wp_json_encode($realty->getTitle()); ?>
        };
    </script>
</section>
<?php endif; ?>
