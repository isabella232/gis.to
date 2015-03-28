<div class="wizard-card wizard-card-software">

<h1>Программное обеспечение</h1>

<div class="alert alert-info">
    <p>Здесь Вы можете получить бесплатное программное обеспечение для работы с геоданными. Можно выбрать сразу несколько программ.</p>
</div>

<!-- div class="alert alert-warning">
    <p>Здесь вы можете выбрать нужное вам ПО, ссылки на его скачивание вместе с другими услугами, если вы их выбрали,
        появятся после нажатия кнопки «Готово». <a class="more-show" href="#">Подробнее</a></p>
    <div class="more-content" style="display: none">
        <p>Подробное описание</p>
    </div>
</div -->

    <div class="row">

    <div class="col-sm-6 col-md-4">
        <div class="thumbnail block-software-0" data-summary="summary-software-0" style="opacity:0.5">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>NextGIS QGIS</h2>
                <p>Мощная ГИС для настольного компьютера позволяет выполнять широкий спектр действий с геоданными.</p>

                <!--<a class="thumbnail-form-show" href="#">Выбрать</a>

                <input type="hidden" id="software-0-selected" name="result[software][0][selected]" value="0" />

                <div class="thumbnail-form-content" style="display: none">
                    <div class="form-group">
                        <label class="control-label" for="software-0-version">Версия</label>
                        <select class="form-control" id="software-0-version" name="result[software][0][version]">
                        </select>
                    </div>
                    <a class="thumbnail-form-hide" href="#">Отмена</a>
                </div>-->

                <p style="color:red">Скоро!</p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="thumbnail block-software-1" data-summary="summary-software-1" style="opacity:0.5">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>NextGIS Manager</h2>
                <p>Управляйте геоданными, ничего лишнего.</p>

                <!--<a class="thumbnail-form-show" href="#">Выбрать</a>

                <input type="hidden" id="software-1-selected" name="result[software][1][selected]" value="0" />

                <div class="thumbnail-form-content" style="display: none">
                    <div class="form-group">
                        <label class="control-label" for="software-1-version">Версия</label>
                        <select class="form-control" id="software-1-version" name="result[software][1][version]">
                        </select>
                    </div>
                    <a class="thumbnail-form-hide" href="#">Отмена</a>
                </div>-->

                <p style="color:red">Скоро!</p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="thumbnail block-software-2" data-summary="summary-software-2" style="opacity:0.5">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>NextGIS Mobile</h2>
                <p>Начинате использовать свои геоданные в устройстве на Android прямо сейчас.</p>

                <!--<a class="thumbnail-form-show" href="#">Выбрать</a>

                <input type="hidden" id="software-2-selected" name="result[software][2][selected]" value="0" />

                <div class="thumbnail-form-content" style="display: none">
                    <div class="form-group">
                        <label class="control-label" for="software-2-version">Версия</label>
                        <select class="form-control" id="software-2-version" name="result[software][2][version]">
                        </select>
                    </div>
                    <a class="thumbnail-form-hide" href="#">Отмена</a>
                </div>-->

                <p style="color:red">Скоро!</p>
            </div>
        </div>
    </div>

</div>

<div class="page-nav">
    <a type="submit" class="btn btn-default btn-primary tab-nav" data-tab="prev"><span class="glyphicon glyphicon-chevron-left"></span> Обратно</a>
    <a type="submit" class="btn btn-default btn-primary tab-nav summary" data-tab="summary">Готово</a>
    <a type="submit" class="btn btn-default btn-primary tab-nav" data-tab="next">Дальше <span class="glyphicon glyphicon-chevron-right"></span></a>
</div>

</div>

<script>

    $(document).ready(function() {
        $.getJSON('<?= Core::$config['http_root'] ?>/data/software.json', function (data) {
            $('#software-0-version').empty();
            $('#software-1-version').empty();
            $('#software-2-version').empty();
            $.each(data, function() {
                switch (this.type) {
                    case 'qgis': $('#software-0-version').append(new Option(this.title, this.id)); break;
                    case 'manager': $('#software-1-version').append(new Option(this.title, this.id)); break;
                    case 'mobile': $('#software-2-version').append(new Option(this.title, this.id)); break;
                }
            });
        });
    });

</script>
