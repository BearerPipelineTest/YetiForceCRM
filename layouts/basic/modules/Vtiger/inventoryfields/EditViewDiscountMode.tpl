{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-inventoryfields-EditViewDiscountMode -->
	{assign var=VALUE value=$INVENTORY_MODEL->getEditValue($ITEM_DATA, $FIELD->getColumnName())}
	<select {if $ROW_NO} name="inventory[{$ROW_NO}][{$FIELD->getColumnName()}]" {/if} class="select2 js-discountmode"
		title="{\App\Language::translate('LBL_DISCOUNT_MODE', $MODULE)}" {if $FIELD->isReadOnly()}readonly="readonly" {/if} data-js="change|val">
		<option value="0" {if $VALUE == '0'}selected{/if}>{\App\Language::translate('LBL_GROUP', $MODULE)}</option>
		<option value="1" {if $VALUE == '1'}selected{/if}>{\App\Language::translate('LBL_INDIVIDUAL', $MODULE)}</option>
	</select>
	<!-- /tpl-Base-inventoryfields-EditViewDiscountMode -->
{/strip}
