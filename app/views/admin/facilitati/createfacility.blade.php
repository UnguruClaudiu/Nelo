<form action="" method="post" id="adauga_facilitate_form" name="adauga_facilitate_form">
    <!-- Form -->
    <div class="form">
        <div style="float: left; padding: 5px;">
            <label for="nume">  Facilitate   </label>
            <input name="nume"      id="nume"    type="text" value="{{ $nume or ''}}"     size="25"/><br>
        </div>
    </div>

    <div class="buttons">
        <input type="submit" class="button" value="Adauga" {{ $is_ajax or '' }} />
    </div>
</form>