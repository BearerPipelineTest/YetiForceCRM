{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-inventoryfields-EditViewDiscount -->
	{assign var=VALUE value=$INVENTORY_MODEL->getEditValue($ITEM_DATA, $FIELD->getColumnName())}
	<div>
		<div class="input-group input-group-sm">
			<input type="text" name="inventory[{$ROW_NO}][{$FIELD->getColumnName()}]" value="{$FIELD->getDisplayValue($VALUE, $ITEM_DATA, true)|escape}" class="discount form-control form-control-sm" readonly="readonly" />
			{assign var=DISCOUNT_MODE value=$INVENTORY_MODEL->getEditValue($ITEM_DATA, 'discountmode', Vtiger_Inventory_Model::getDiscountsConfig('default_mode'))}
			{assign var=DISCOUNT_PARAMS value=$INVENTORY_MODEL->getEditValue($ITEM_DATA, 'discountparam')}
			<input name="inventory[{$ROW_NO}][discountparam]" type="hidden" value="{if $DISCOUNT_PARAMS}{\App\Purifier::encodeHtml($DISCOUNT_PARAMS)}{/if}" class="discountParam" />
			<span class="input-group-append u-cursor-pointer js-change-discount {if $DISCOUNT_MODE == 0}d-none{/if}">
				<div class="input-group-text">
					<span class="small">
						<span class="fas fa-long-arrow-alt-down"></span>
						<span class="fas fa-percent"></span>
					</span>
				</div>
			</span>
		</div>
	</div>
	<!-- /tpl-Base-inventoryfields-EditViewDiscount -->
{/strip}
