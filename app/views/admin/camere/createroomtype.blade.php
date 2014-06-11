<form action="" method="post" id="adauga_tip_camera_form" name="adauga_tip_camera_form">
    <!-- Form -->
    <div class="form">  
        <div style="float: left; padding: 5px;">
            <label for="nume">  Tip nou*      </label>
            <input name="nume"      id="nume"    type="text" value="{{ $nume or ''}}"     size="25"/><br>
            <label for="nume">  Descriere      </label>
            <input name="descriere"      id="descriere"    type="text" value="{{ $descriere or ''}}"     size="25"/>
        </div>
    </div>

    <div class="buttons">
        <input type="submit" class="button" value="Adauga" {{ $is_ajax or '' }} />
    </div>
</form>