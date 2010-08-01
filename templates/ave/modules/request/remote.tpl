<form method="post" class="ctrlrequest" action="">

  <table>

    <tr>
{foreach from=$ctrlrequest item=items key=selname}
      <td>

        <label>{$items.titel} </label>

        <select name="fld[{$selname}]">

          <option value=''>Все</option>
          {html_options values=$items.options output=$items.options selected=$items.selected}

        </select>

      </td>
{/foreach}
      <td><input type="submit" class="button" value="Показать" /></td>

    </tr>

  </table>

</form>