{if $excl_pay==1}
	{if $excl_chk==1}
	  <p>Ошибка! У вас нет прав на загрузку этого файла.</p>
	{else}
		{if $pay_sum==0 || $diff==0}
			<p>Внимание:Вам не требуется оплачивать данный файл. Вы можете загрузить его, вернувшись на страницу <a href="index.php?module=download&action=showfile&file_id={$file_id}&categ={$cat_id}">назад</a>.</p>
		{else}
			<form name="pay" method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" id="pay">
      	<table align="center" cellpadding="0" cellspacing="0" width="98%">
          <tr>
              <td align="center"  class="mod_download_dlbox">
                 <h2>Взнос на открытие файла</h2>
              </td>
          </tr>
          <tr>
              <td align="center"><br><br>
				        {if $diff<>$pay_sum}
					      	Взнос составляет {$diff} {$pay_val}. Внимание:До этого вы уже оплатили часть стоимости данного файла.
                                                                               Если Вы видите это сообщение, то это означает, что стоимость этого файла 
                                                                               была изменена после Вашей последней оплаты и Вам необходимо доплатить лишь разницу в стоимости.
					      	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$diff}"><br>
				        {else}
					      	Взнос составляет {$pay_sum} {$pay_val}.
					      	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$pay_sum}"><br>
				        {/if}
								<br><input type="hidden" name="LMI_PAYMENT_DESC" value="{$pay_descr}">
								<input type="hidden" name="LMI_PAYMENT_NO" value="{$pay_num}">
								<input type="hidden" name="LMI_PAYEE_PURSE" value="{$wm_purse}">
								<input type="hidden" name="LMI_SIM_MODE" value="0">
								<input type="hidden" name="pay_fileid" value="{$file_id}">
								<input type="hidden" name="pay_count" value="{$pay_count}">
								<input type="hidden" name="pay_userid" value="{$user_id}">
								<input type="hidden" name="pay_userIP" value="{$user_IP}">
          	</td>
          </tr>
          <tr>
              <td align="center">
					<input type="submit" value="Оплатить">
              </td>
          </tr>
       </table>
      </form>
		{/if}
	{/if}
{elseif $pay_type==0}
	{if $pay_sum==0}
		<p>Внимание:Вам не требуется оплачивать данный файл. Вы можете загрузить его, вернувшись на страницу <a href="index.php?module=download&action=showfile&file_id={$file_id}&categ={$cat_id}">назад</a>.</p>
	{else}
		<form name="pay" method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" id="pay">
    	<table align="center" cellpadding="0" cellspacing="0" width="98%">
        <tr>
            <td align="center"  class="mod_download_dlbox">
               <h2>Взнос на открытие файла</h2>
            </td>
        </tr>
        <tr>
            <td align="center"><br><br>
			        Стоимость файла составляет {$pay_sum} {$pay_val}.<br><br>
			        Взнос <input type="text" name="LMI_PAYMENT_AMOUNT" value="{$pay_sum}" onblur="if (this.value>{$pay_sum}) this.value={$pay_sum};"> {$pay_val}<br>
							<br><input type="hidden" name="LMI_PAYMENT_DESC" value="{$pay_descr}">
							<input type="hidden" name="LMI_PAYMENT_NO" value="{$pay_num}">
							<input type="hidden" name="LMI_PAYEE_PURSE" value="{$wm_purse}">
							<input type="hidden" name="LMI_SIM_MODE" value="0">
							<input type="hidden" name="pay_fileid" value="{$file_id}">
							<input type="hidden" name="pay_count" value="{$pay_count}">
							<input type="hidden" name="pay_userid" value="{$user_id}">
							<input type="hidden" name="pay_userIP" value="{$user_IP}">
        	</td>
        </tr>
        <tr>
            <td align="center">
				<input type="submit" value="Оплатить">
            </td>
        </tr>
     </table>
    </form>
	{/if}
{elseif $pay_type==1}
	{if $pay_sum==0 || $diff==0}
		<p>Внимание:Вам не требуется оплачивать данный файл. Вы можете загрузить его, вернувшись на страницу<a href="index.php?module=download&action=showfile&file_id={$file_id}&categ={$cat_id}">назад</a>.</p>
	{else}
		<form name="pay" method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" id="pay">
    	<table align="center" cellpadding="0" cellspacing="0" width="98%">
        <tr>
            <td align="center"  class="mod_download_dlbox">
               <h2>Взнос на открытие файла</h2>
            </td>
        </tr>
        <tr>
            <td align="center"><br><br>
			        {if $diff<>$pay_sum}
				      	Взнос составляет {$diff} {$pay_val}. Внимание:До этого вы уже оплатили часть стоимости данного файла.
                                                                         Если Вы видите это сообщение, то это означает, что стоимость этого файла 
                                                                         была изменена после Вашей последней оплаты и Вам необходимо доплатить лишь разницу в стоимости.
				      	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$diff}"><br>
			        {else}
				      	Взнос составляет {$pay_sum} {$pay_val}.
				      	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$pay_sum}"><br>
			        {/if}
							<br><input type="hidden" name="LMI_PAYMENT_DESC" value="{$pay_descr}">
							<input type="hidden" name="LMI_PAYMENT_NO" value="{$pay_num}">
							<input type="hidden" name="LMI_PAYEE_PURSE" value="{$wm_purse}">
							<input type="hidden" name="LMI_SIM_MODE" value="0">
							<input type="hidden" name="pay_fileid" value="{$file_id}">
							<input type="hidden" name="pay_count" value="{$pay_count}">
							<input type="hidden" name="pay_userid" value="{$user_id}">
							<input type="hidden" name="pay_userIP" value="{$user_IP}">
        	</td>
        </tr>
        <tr>
            <td align="center">
				<input type="submit" value="Оплатить">
            </td>
        </tr>
     </table>
    </form>
	{/if}
{/if}