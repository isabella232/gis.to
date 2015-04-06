<div class="wizard-card wizard-card-data">

<h1>Геоданные</h1>

<div class="alert alert-info">
    <p>Здесь Вы можете получить данные для вашей ГИС.</p>
</div>

<div class="row">

    <div class="col-sm-6 col-md-6">
        <div class="thumbnail thumbnail-with-image thumbnail-form block-data-0" data-summary="summary-data-0" style="opacity:0.5">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>Базовые геоданные</h2>
                <p>Картографическая основа для вашего проекта: границы областей и районов, дороги и дома.</p>

                <!--<a class="thumbnail-form-show" href="#">Выбрать</a>

                <input type="hidden" id="data-0-selected" name="result[data][0][selected]" value="0" />

                <div class="thumbnail-form-content" style="display: none">
                    <div class="form-group">
                        <label class="control-label" for="region">Регион</label>
                        <select class="form-control" id="region" name="result[data][0][id]">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="format">Формат</label>
                        <select class="form-control" id="format" name="format">
                            <option value="shp">ESRI Shape</option>
                        </select>
                    </div>
                    <a class="thumbnail-form-hide" href="#">Отмена</a>
                </div>-->

                <p style="color:red">Скоро!</p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6">
        <div class="thumbnail thumbnail-with-image thumbnail-form block-data-1" data-summary="summary-data-1" style="opacity:0.5">
            <div class="caption">
                <h2>Тематические геоданные</h2>
                <p>Специальные данные: рельеф, почвы, растительность, кадастр.</p>
                <p style="color:red">Скоро!</p>
            </div>
        </div>
    </div>
</div>

<div class="page-nav">
    <a type="submit" class="btn btn-default btn-primary tab-nav summary" data-tab="summary" style="float:left;">Заказать</a>
    <span  style="float:right;">
        <a type="submit" class="btn btn-default btn-primary tab-nav" data-tab="prev"><span class="glyphicon glyphicon-chevron-left"></span> Главная</a>
        <a type="submit" class="btn btn-default btn-primary tab-nav" data-tab="next">Веб <span class="glyphicon glyphicon-chevron-right"></span></a>
    </span>
</div>

</div>

<script>

    $(document).ready(function() {
        $('.thumbnail-form-show').click(function () {
            var container = $(this).parents('.thumbnail').first();
            container.toggleClass('selected');
            container.find('.thumbnail-form-content').first().slideToggle();
            $(this).hide();
            updateSummaryPanel();
        });

        $('.thumbnail-form-hide').click(function () {
            var container = $(this).parents('.thumbnail').first();
            container.toggleClass('selected');
            container.find('.thumbnail-form-content').first().slideToggle();
            container.find('.thumbnail-form-show').first().slideDown();
            updateSummaryPanel();
        });

        $('.alert .more-show').click(function () {
            var container = $(this).parents('.alert').first();
            container.find('.more-content').first().slideToggle();
            $(this).hide();
        });

        $.getJSON('<?= Core::$config['http_root'] ?>/data/osm-data.json', function (data) {
            $('#region').empty();
            $.each(data, function() {
                $('#region').append(new Option(this.title, this.code));
            });
        });
    });

</script>
