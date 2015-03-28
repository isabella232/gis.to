<div class="wizard-card wizard-card-index">

<h1>С чего начнем?</h1>

<div class="alert alert-info">
    <p>Выберите интересующую вас тему, у вас будет возможность добавить другие позиции далее.</p>
</div>

<div class="row">

    <div class="col-sm-6 col-md-6">
        <div class="thumbnail thumbnail-with-image img-category-data index-category">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>Геоданные</h2>
                <p>Базовые и тематические данные для вашей системы.</p>
                <a class="tab-nav" data-tab="data" href="#data">Перейти</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6">
        <div class="thumbnail thumbnail-with-image img-category-hosting index-category">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>Веб</h2>
                <p>Разверните свой картографический проект в веб.</p>
                <a class="tab-nav" data-tab="hosting" href="#hosting">Перейти</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6">
        <div class="thumbnail thumbnail-with-image img-category-software index-category">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>Софт</h2>
                <p>Бесплатное программное обеспечение для работы с геоданными на настольном компьютере и мобильном.</p>
                <a class="tab-nav" data-tab="software" href="#software">Перейти</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6">
        <div class="thumbnail thumbnail-with-image img-category-support index-category">
            <div class="caption">
                <!--<a class="help" href="#"><span class="help glyphicon glyphicon-question-sign"></span></a>-->

                <h2>Поддержка</h2>
                <p>У вас есть вопросы? У нашей поддержки есть ответы.</p>
                <a class="tab-nav" data-tab="support" href="#support">Перейти</a>
            </div>
        </div>
    </div>

</div>

<!-- div class="page-nav">
    <a class="btn btn-default btn-primary tab-nav" data-tab="next">Дальше <span class="glyphicon glyphicon-chevron-right"></span></a>
</div -->

</div>

<script>

    $(document).ready(function() {

        $('.index-category .tab-nav').click(function () {
            $('#cards').prepend($('#cards a[href="#' + $(this).data('tab') + '"]').parent());
            $('#cards').prepend($('#cards a[href="#home"]').parent());
        });

        $('.tab-nav').click(function () {
            var currentTab = $('#cards-content .active').attr('id');
            if ($(this).data('tab') == 'next') {
                $('#cards a[href="#' + currentTab + '"]').parent().next().children('a').tab('show');
            } else if ($(this).data('tab') == 'prev') {
                $('#cards a[href="#' + currentTab + '"]').parent().prev().children('a').tab('show');
            } else {
                $('#cards a[href="#' + $(this).data('tab') + '"]').tab('show');
            }
        });

        updateSummaryPanel();
    });

    function updateSummaryPanel() {
        $('#cards a[href="#data"]').toggleClass('selected', $('.wizard-card-data .thumbnail.selected').length > 0);
        $('#cards a[href="#hosting"]').toggleClass('selected', $('.wizard-card-hosting .thumbnail.selected').length > 0);
        $('#cards a[href="#software"]').toggleClass('selected', $('.wizard-card-software .thumbnail.selected').length > 0);
        $('#cards a[href="#support"]').toggleClass('selected', $('.wizard-card-support .thumbnail.selected').length > 0);
        if ($('#cards a.selected').length > 0) {
            $('a.summary').removeAttr('disabled');
        } else {
            $('a.summary').attr('disabled', 'disabled');
        }

        summaryUpdate();
    }

</script>
