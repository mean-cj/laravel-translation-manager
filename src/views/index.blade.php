@extends('laravel-translation-manager::layouts.master')

@section('head')
@stop

@section('content')
    {{--<div style="width: 80%; margin: auto;">--}}
    <div class="col-sm-12 translation-manager">
        <div class="row">
            <div class="col-sm-7">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>@lang('laravel-translation-manager::messages.translation-manager')</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p>@lang('laravel-translation-manager::messages.export-warning-text')</p>

                        <?= ifInPlaceEdit("@lang('laravel-translation-manager::messages.import-all-done')") ?>
                        <div class="alert alert-success success-import-all" style="display:none;">
                            <p>@lang('laravel-translation-manager::messages.import-all-done')</p>
                        </div>
                        <?= ifInPlaceEdit("@lang('laravel-translation-manager::messages.import-group-done')", ['group' => $group]) ?>
                        <div class="alert alert-success success-import-group" style="display:none;">
                            <p>@lang('laravel-translation-manager::messages.import-group-done', ['group' => $group]) </p>
                        </div>
                        <?= ifInPlaceEdit("@lang('laravel-translation-manager::messages.search-done')") ?>
                        <div class="alert alert-success success-find" style="display:none;">
                            <p>@lang('laravel-translation-manager::messages.search-done')</p>
                        </div>
                        <?= ifInPlaceEdit("@lang('laravel-translation-manager::messages.done-publishing')", ['group' => $group]) ?>
                        <div class="alert alert-success success-publish" style="display:none;">
                            <p>@lang('laravel-translation-manager::messages.done-publishing', ['group'=> $group])</p>
                        </div>
                        <?= ifInPlaceEdit("@lang('laravel-translation-manager::messages.done-publishing-all')") ?>
                        <div class="alert alert-success success-publish-all" style="display:none;">
                            <p>@lang('laravel-translation-manager::messages.done-publishing-all')</p>
                        </div>

                        <?php if(Session::has('successPublish')) : ?>
                        <div class="alert alert-info">
                            <?php echo Session::get('successPublish'); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @if($adminEnabled)
                            <div class="row">
                                <div class="col-sm-12">
                                    <form id="form-import-all" class="form-import-all" method="POST"
                                            action="<?= action('Vsch\TranslationManager\Controller@postImport', ['group' => '*']) ?>" data-remote="true" role="form">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= ifEditTrans('laravel-translation-manager::messages.import-add') ?>
                                                <?= ifEditTrans('laravel-translation-manager::messages.import-replace') ?>
                                                <?= ifEditTrans('laravel-translation-manager::messages.import-fresh') ?>
                                                <div class="input-group-sm">
                                                    <select name="replace" class="import-select form-control">
                                                        <option value="0"><?= noEditTrans('laravel-translation-manager::messages.import-add') ?></option>
                                                        <option value="1"><?= noEditTrans('laravel-translation-manager::messages.import-replace') ?></option>
                                                        <option value="2"><?= noEditTrans('laravel-translation-manager::messages.import-fresh') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= ifEditTrans('laravel-translation-manager::messages.import-groups') ?>
                                                <?= ifEditTrans('laravel-translation-manager::messages.loading') ?>
                                                <button type="submit" form="form-import-all" class="btn btn-sm btn-success"
                                                        data-disable-with="<?= noEditTrans('laravel-translation-manager::messages.loading') ?>">
                                                    <?= noEditTrans('laravel-translation-manager::messages.import-groups') ?>
                                                </button>
                                                <?= ifEditTrans('laravel-translation-manager::messages.zip-all') ?>
                                                <a href="<?= action('Vsch\TranslationManager\Controller@getZippedTranslations', ['group' => '*']) ?>"
                                                <div class="input-group" style="float:right; display:inline">
                                                    <?= ifEditTrans('laravel-translation-manager::messages.download-zip') ?>
                                                    <a href="<?= action('Vsch\TranslationManager\Controller@getZippedTranslations', ['group' => '*']) ?>"
                                                            role="button" class="btn btn-primary btn-sm">
                                                    <?= noEditTrans('laravel-translation-manager::messages.zip-all') ?>
                                                    </a>
                                                    <?= ifEditTrans('laravel-translation-manager::messages.find-in-files') ?>
                                                    <?= ifEditTrans('laravel-translation-manager::messages.searching') ?>
                                                    <button type="submit" form="form-find" class="btn btn-sm btn-warning"
                                                            data-disable-with="<?= noEditTrans('laravel-translation-manager::messages.searching') ?>">
                                                        <?= noEditTrans('laravel-translation-manager::messages.find-in-files') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?= ifEditTrans('laravel-translation-manager::messages.confirm-find') ?>
                                    <form id="form-find" class="form-inline form-find" method="POST" action="<?= action('Vsch\TranslationManager\Controller@postFind') ?>"
                                            data-remote="true" role="form" data-confirm="<?= noEditTrans('laravel-translation-manager::messages.confirm-find') ?>"></form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div style="min-height: 10px"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= ifEditTrans('laravel-translation-manager::messages.choose-group'); ?>
                                        <div class="input-group-sm">
                                            <?= Form::select('group', $groups, $group, array('form' => 'form-select', 'class' => 'group-select form-control')) ?>
                                        </div>
                                    </div>
                                    <?php if ($adminEnabled): ?>
                                    <div class="col-sm-6">
                                        <?php if ($group): ?>
                                        <button type="submit" form="form-publish-group" class="btn btn-sm btn-info input-control"
                                                data-disable-with="<?= noEditTrans('laravel-translation-manager::messages.publishing') ?>">
                                            <?= noEditTrans('laravel-translation-manager::messages.publish') ?>
                                        </button>
                                        <?= ifEditTrans('laravel-translation-manager::messages.zip-group') ?>
                                        <a href="<?= action('Vsch\TranslationManager\Controller@getZippedTranslations', ['group' => $group]) ?>"
                                                role="button" class="btn btn-primary btn-sm">
                                            <?= noEditTrans('laravel-translation-manager::messages.zip-group') ?>
                                        </a>
                                        <?php endif; ?>
                                        <div class="input-group" style="float:right; display:inline">
                                            <?php if ($group): ?>
                                            <button type="submit" form="form-import" class="btn btn-sm btn-success"
                                                    data-disable-with="<?= noEditTrans('laravel-translation-manager::messages.loading') ?>">
                                                <?= noEditTrans('laravel-translation-manager::messages.import-group') ?>
                                            </button>
                                            <?= ifEditTrans('laravel-translation-manager::messages.delete') ?>
                                            <?= ifEditTrans('laravel-translation-manager::messages.deleting') ?>
                                            <button type="submit" form="form-delete-group" class="btn btn-sm btn-danger"
                                                    data-disable-with="<?= noEditTrans('laravel-translation-manager::messages.deleting') ?>">
                                                <?= noEditTrans('laravel-translation-manager::messages.delete') ?>
                                            </button>
                                            <?= ifEditTrans('laravel-translation-manager::messages.publish') ?>
                                            <?php endif; ?>

                                            <button type="submit" form="form-publish-all" class="btn btn-sm btn-warning input-control"
                                                    data-disable-with="<?= noEditTrans('laravel-translation-manager::messages.publishing') ?>">
                                                <?= noEditTrans('laravel-translation-manager::messages.publish-all') ?>
                                            </button>
                                            <?= ifEditTrans('laravel-translation-manager::messages.publish-all') ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?= ifEditTrans('laravel-translation-manager::messages.confirm-delete') ?>
                                    <form id="form-delete-group" class="form-inline form-delete-group" method="POST"
                                            action="<?= action('Vsch\TranslationManager\Controller@postDeleteAll', $group) ?>" data-remote="true" role="form"
                                            data-confirm="<?= noEditTrans('laravel-translation-manager::messages.confirm-delete', ['group' => $group]) ?>"></form>
                                    <form id="form-import" class="form-inline form-import" method="POST"
                                            action="<?= action('Vsch\TranslationManager\Controller@postImport', $group) ?>" data-remote="true" role="form"></form>
                                    <form role="form" class="form" id="form-select"></form>
                                    <form id="form-publish-group" class="form-inline form-publish-group" method="POST"
                                            action="<?= action('Vsch\TranslationManager\Controller@postPublish', $group) ?>" data-remote="true" role="form"></form>
                                    <form id="form-publish-all" class="form-inline form-publish-all" method="POST"
                                            action="<?= action('Vsch\TranslationManager\Controller@postPublish', '*') ?>" data-remote="true" role="form"></form>
                                </div>
                            </div>
                        </div>
                        <div style="min-height: 10px"></div>

                        <div class="row">
                            <?php if(!$group): ?>
                            <div class="col-sm-10">
                                <p>@lang('laravel-translation-manager::messages.choose-group-text')</p>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#searchModal" style="float:right; display:inline">
                                    <?= noEditTrans('laravel-translation-manager::messages.search') ?>
                                </button>
                                <?= ifEditTrans('laravel-translation-manager::messages.search') ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div style="min-height: 10px"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="min-height: 10px"></div>
                        <form class="form-inline" id="form-interface-locale" class="form-interface-locale" method="GET"
                                action="<?= action('Vsch\TranslationManager\Controller@getInterfaceLocale') ?>">
                            <div class="row">
                                <div class=" col-sm-3">
                                    <div class="input-group-sm">
                                        <label for="interface-locale"><?= trans('laravel-translation-manager::messages.interface-locale') ?>:</label>
                                        <select name="l" id="interface-locale" class="form-control" ?>">
                                        @foreach($locales as $locale)
                                            <option value="<?=$locale?>"<?= $currentLocale === $locale ? ' selected="selected"' : ''?>><?= $locale ?></option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="input-group-sm">
                                        <label for="translating-locale"><?= trans('laravel-translation-manager::messages.translating-locale') ?>:</label>
                                        <select name="t" id="translating-locale" class="form-control" ?>">
                                        @foreach($locales as $locale)
                                            @if($locale !== $primaryLocale) continue;
                                            <option value="<?=$locale?>"<?= $translatingLocale === $locale ? ' selected="selected"' : ''?>><?= $locale ?></option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="input-group-sm">
                                        <label for="primary-locale"><?= trans('laravel-translation-manager::messages.primary-locale') ?>:</label>
                                        <select name="p" id="primary-locale" class="form-control" ?>">
                                        @foreach($locales as $locale)
                                            <option value="<?=$locale?>"<?= $primaryLocale === $locale ? ' selected="selected"' : ''?>><?= $locale ?></option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="input-group" style="float:right; display:inline">
                                        <?= ifEditTrans('laravel-translation-manager::messages.in-place-edit') ?>
                                        <a class="btn btn-sm btn-primary" role="button" href="<?= action('Vsch\TranslationManager\Controller@getToggleInPlaceEdit') ?>"><?= noEditTrans('laravel-translation-manager::messages.in-place-edit') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div style="min-height: 10px"></div>
                            <div class="row">
                                <div class=" col-sm-3">
                                    <div class="row">
                                        <div class=" col-sm-12">
                                            <?= formSubmit(trans('laravel-translation-manager::messages.display-locales'), ['class' => "btn btn-sm btn-primary"]) ?>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=" col-sm-12">
                                            <div style="min-height: 10px"></div>
                                            <?= ifEditTrans('laravel-translation-manager::messages.check-all') ?>
                                            <button id="display-locale-all" class="btn btn-sm btn-default"><?= noEditTrans('laravel-translation-manager::messages.check-all')?></button>
                                            <?= ifEditTrans('laravel-translation-manager::messages.check-none') ?>
                                            <button id="display-locale-none" class="btn btn-sm btn-default"><?= noEditTrans('laravel-translation-manager::messages.check-none')?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-9">
                                    <div class="input-group-sm">
                                    @foreach($locales as $locale)
                                        <label>
                                            <input <?= $locale !== $primaryLocale && $locale !== $translatingLocale ? ' class="display-locale" ' : '' ?> name="d[]" type="checkbox" value="<?=$locale?>"
                                                    <?= ($locale === $primaryLocale || $locale === $translatingLocale || array_key_exists($locale, $displayLocales)) ? 'checked' : '' ?>
                                                    <?= $locale === $primaryLocale ? 'disabled="true"' : '' ?>
                                                    ><?= $locale ?>
                                        </label>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        @include('laravel-translation-manager::dashboard')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @if($mismatchEnabled && !empty($mismatches))
                            @include('laravel-translation-manager::mismatched')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <?= ifEditTrans('laravel-translation-manager::messages.enter-translation') ?>
        <?= ifEditTrans('laravel-translation-manager::messages.missmatched-quotes') ?>
        <script>
            var MISSMATCHED_QUOTES_MESSAGE = "{{noEditTrans(('laravel-translation-manager::messages.missmatched-quotes'))}}";
        </script>

        <?php if($group): ?>
        <div class="row">
            <div class="col-sm-12 ">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <?= ifEditTrans('laravel-translation-manager::messages.suffixed-keyops') ?>
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <?= noEditTrans('laravel-translation-manager::messages.suffixed-keyops') ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <!-- Add Keys Form -->
                                <div class="col-sm-12">
                                    {{ Form::open(['id' => 'form-addkeys', 'method' => 'POST', 'action' => ['Vsch\TranslationManager\Controller@postAdd', $group]]) }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="keys">@lang('laravel-translation-manager::messages.keys'):</label>
                                            <?= ifEditTrans('laravel-translation-manager::messages.addkeys-placeholder') ?>
                                            {{ Form::textarea('keys', Input::old('keys'), ['class'=>"form-control", 'rows'=>"4", 'style'=>"resize: vertical",
                                                    'placeholder'=>noEditTrans('laravel-translation-manager::messages.addkeys-placeholder')]) }}
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="suffixes">@lang('laravel-translation-manager::messages.suffixes'):</label>
                                            <?= ifEditTrans('laravel-translation-manager::messages.addsuffixes-placeholder') ?>
                                            {{ Form::textarea('suffixes', Input::old('suffixes'), ['class'=>"form-control", 'rows'=>"4", 'style'=>"resize: vertical",
                                                    'placeholder'=> noEditTrans('laravel-translation-manager::messages.addsuffixes-placeholder')]) }}
                                        </div>
                                    </div>
                                    <div style="min-height: 10px"></div>
                                    <script>
                                        var currentGroup = '{{{$group}}}';
                                        function addStandardSuffixes(event) {
                                            event.preventDefault();
                                            $("#form-addkeys").first().find("textarea[name='suffixes']")[0].value = "-type\n-header\n-heading\n-description\n-footer" + (currentGroup === 'systemmessage-texts' ? '\n-footing' : '');
                                        }
                                        function clearSuffixes(event) {
                                            event.preventDefault();
                                            $("#form-addkeys").first().find("textarea[name='suffixes']")[0].value = "";
                                        }
                                        function clearKeys(event) {
                                            event.preventDefault();
                                            $("#form-addkeys").first().find("textarea[name='keys']")[0].value = "";
                                        }
                                        function postDeleteSuffixedKeys(event) {
                                            event.preventDefault();
                                            var elem = $("#form-addkeys").first();
                                            elem[0].action = "{{action('Vsch\TranslationManager\Controller@postDeleteSuffixedKeys', $group)}}";
                                            elem[0].submit();
                                        }
                                    </script>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= formSubmit(trans('laravel-translation-manager::messages.addkeys'), ['class' => "btn btn-sm btn-primary"]) ?>
                                            <?= ifEditTrans('laravel-translation-manager::messages.clearkeys') ?>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="clearKeys(event)"><?= noEditTrans('laravel-translation-manager::messages.clearkeys') ?></button>
                                            <div class="input-group" style="float:right; display:inline">
                                                <?= ifEditTrans('laravel-translation-manager::messages.deletekeys') ?>
                                                <button class="btn btn-sm btn-danger" onclick="postDeleteSuffixedKeys(event)">
                                                    <?= noEditTrans('laravel-translation-manager::messages.deletekeys') ?>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= ifEditTrans('laravel-translation-manager::messages.addsuffixes') ?>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="addStandardSuffixes(event)"><?= noEditTrans('laravel-translation-manager::messages.addsuffixes') ?></button>
                                            <?= ifEditTrans('laravel-translation-manager::messages.clearsuffixes') ?>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="clearSuffixes(event)"><?= noEditTrans('laravel-translation-manager::messages.clearsuffixes') ?></button>
                                        </div>
                                        <div class="col-sm-2">
                                            <span style="float:right; display:inline">
                                                <?= ifEditTrans('laravel-translation-manager::messages.search'); ?>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#searchModal">
                                                    <?= noEditTrans('laravel-translation-manager::messages.search') ?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <?= ifEditTrans('laravel-translation-manager::messages.wildcard-keyops') ?>
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <?= noEditTrans('laravel-translation-manager::messages.wildcard-keyops') ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <!--
                                        Key Ops Form
                                    -->
                                    <div id="wildcard-keyops-results" class="results"></div>
                                    {{ Form::open(['id' => 'form-keyops', 'data-remote'=>"true", 'method' => 'POST', 'action' => ['Vsch\TranslationManager\Controller@postPreviewKeys', $group]]) }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="srckeys">@lang('laravel-translation-manager::messages.srckeys'):</label>
                                            <?= ifEditTrans('laravel-translation-manager::messages.srckeys-placeholder') ?>
                                            {{ Form::textarea('srckeys', Input::old('srckeys'), ['id' => 'srckeys', 'class'=>"form-control", 'rows'=>"4", 'style'=>"resize: vertical",
                                                    'placeholder'=>noEditTrans('laravel-translation-manager::messages.srckeys-placeholder')]) }}
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="dstkeys">@lang('laravel-translation-manager::messages.dstkeys'):</label>
                                            <?= ifEditTrans('laravel-translation-manager::messages.dstkeys-placeholder') ?>
                                            {{ Form::textarea('dstkeys', Input::old('dstkeys'), ['id' => 'dstkeys', 'class'=>"form-control", 'rows'=>"4", 'style'=>"resize: vertical",
                                                    'placeholder'=> noEditTrans('laravel-translation-manager::messages.dstkeys-placeholder')]) }}
                                        </div>
                                    </div>
                                    <div style="min-height: 10px"></div>
                                    <script>
                                        var currentGroup = '{{{$group}}}';
                                        function clearDstKeys(event) {
                                            event.preventDefault();
                                            $("#form-keyops").first().find("textarea[name='dstkeys']")[0].value = "";
                                        }
                                        function clearSrcKeys(event) {
                                            event.preventDefault();
                                            $("#form-keyops").first().find("textarea[name='srckeys']")[0].value = "";
                                        }
                                        function postPreviewKeys(event) {
                                            //event.preventDefault();
                                            var elem = $("#form-keyops").first();
                                            elem[0].action = "{{action('Vsch\TranslationManager\Controller@postPreviewKeys', $group)}}";
                                            //elem[0].submit();
                                        }
                                        function postMoveKeys(event) {
                                            //event.preventDefault();
                                            var elem = $("#form-keyops").first();
                                            elem[0].action = "{{action('Vsch\TranslationManager\Controller@postMoveKeys', $group)}}";
                                            //elem[0].submit();
                                        }
                                        function postCopyKeys(event) {
                                            //event.preventDefault();
                                            var elem = $("#form-keyops").first();
                                            elem[0].action = "{{action('Vsch\TranslationManager\Controller@postCopyKeys', $group)}}";
                                            //elem[0].submit();
                                        }
                                        function postDeleteKeys(event) {
                                            //event.preventDefault();
                                            var elem = $("#form-keyops").first();
                                            elem[0].action = "{{action('Vsch\TranslationManager\Controller@postDeleteKeys', $group)}}";
                                            //elem[0].submit();
                                        }
                                    </script>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= ifEditTrans('laravel-translation-manager::messages.clearsrckeys') ?>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="clearSrcKeys(event)"> <?= noEditTrans('laravel-translation-manager::messages.clearsrckeys') ?></button>
                                            <div class="input-group" style="float:right; display:inline">
                                                <?= formSubmit(trans('laravel-translation-manager::messages.preview'), [
                                                        'class' => "btn btn-sm btn-primary",
                                                        'onclick' => 'postPreviewKeys(event)'
                                                ]) ?>
                                                <?= ifEditTrans('laravel-translation-manager::messages.copykeys'); ?>
                                                <button class="btn btn-sm btn-primary" onclick="postCopyKeys(event)">
                                                    <?= noEditTrans('laravel-translation-manager::messages.copykeys') ?>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= ifEditTrans('laravel-translation-manager::messages.cleardstkeys') ?>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="clearDstKeys(event)"><?= noEditTrans('laravel-translation-manager::messages.cleardstkeys') ?></button>
                                            <div class="input-group" style="float:right; display:inline">
                                                <?= ifEditTrans('laravel-translation-manager::messages.movekeys') ?>
                                                <button class="btn btn-sm btn-warning" onclick="postMoveKeys(event)">
                                                    <?= noEditTrans('laravel-translation-manager::messages.movekeys') ?>
                                                </button>
                                                <?= ifEditTrans('laravel-translation-manager::messages.deletekeys') ?>
                                                <button class="btn btn-sm btn-danger" onclick="postDeleteKeys(event)">
                                                    <?= noEditTrans('laravel-translation-manager::messages.deletekeys') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($yandex_key)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <?= ifEditTrans('laravel-translation-manager::messages.translation-ops') ?>
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <?= noEditTrans('laravel-translation-manager::messages.translation-ops') ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <textarea id="primary-text" class="form-control" rows="3" name="keys" style="resize: vertical;"
                                                placeholder="<?= $primaryLocale ?>"></textarea>
                                        <div style="min-height: 10px"></div>
                                        <span style="float:right; display:inline">
                                            <button id="translate-primary-current" type="button" class="btn btn-sm btn-primary">
                                                <?= $primaryLocale ?> <i class="glyphicon glyphicon-share-alt"></i> <?= $translatingLocale ?>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <textarea id="current-text" class="form-control" rows="3" name="keys" style="resize: vertical;"
                                                placeholder="<?= $translatingLocale ?>"></textarea>
                                        <div style="min-height: 10px"></div>
                                        <button id="translate-current-primary" type="button" class="btn btn-sm btn-primary">
                                            <?= $translatingLocale ?> <i class="glyphicon glyphicon-share-alt"></i> <?= $primaryLocale ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 ">
                <div style="min-height: 10px"></div>
                <table class="table table-condensed table-striped table-translations">
                    <thead>
                        <tr>
                            <?php if($adminEnabled): ?>
                            <th width="1%">&nbsp;</th>
                            <?php endif; ?>
                            <th width="20%">@lang('laravel-translation-manager::messages.key')</th>
                            <?php
                                $setWidth = count($displayLocales);
                                if ($setWidth > 2) {
                                    $mainWidth = 30;
                                }
                                else
                                {
                                    $mainWidth = 40;
                                }
                                $col = 0;
                            ?>
                            <?php foreach($locales as $locale): ?>
                                <?php if (!array_key_exists($locale, $displayLocales)) continue; ?>
                            <?php if ($col < 2): ?>
                            <?php if ($col === 1 && isset($yandex_key) && $yandex_key): ?>
                            <th width="<?=$mainWidth?>%"><?= $locale ?>
                                <div class="input-group" style="float:right; display:inline">
                                    <?= ifEditTrans('laravel-translation-manager::messages.auto-translate-disabled') ?>
                                    <?= ifEditTrans('laravel-translation-manager::messages.auto-translate') ?>
                                    <a class="btn btn-sm btn-primary" id="auto-translate" role="button" data-disable-with="<?=noEditTrans('laravel-translation-manager::messages.auto-translate-disabled')?>"
                                        href="#') ?>"><?= noEditTrans('laravel-translation-manager::messages.auto-translate') ?></a>
                                </div>
                            </th>
                            <?php else: ?>
                            <th width="<?=$mainWidth?>%"><?= $locale ?></th><?php endif;?>
                            <?php else: ?>
                            <th><?= $locale ?></th><?php endif; $col++; ?>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $translator = App::make('translator');
                        foreach($translations as $key => $translation)
                        {
                            $is_deleted = 0;
                            foreach($locales as $locale)
                            {
                                if (!array_key_exists($locale, $displayLocales)) continue;
                                if (isset($translation[$locale]) && $translation[$locale]->is_deleted) $is_deleted = 1;
                            }
                        ?>
                        <tr id="<?= str_replace('.', '-', $key) ?>" <?= $is_deleted ? ' class="deleted-translation"' : '' ?>>
                            <?php if($adminEnabled): ?>
                            <td>
                                <a href="<?= action('Vsch\TranslationManager\Controller@postUndelete', [$group, $key]) ?>" class="undelete-key <?= $is_deleted ? "" : "hidden" ?>" data-method="POST"
                                        data-remote="true">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                </a>
                                <a href="<?= action('Vsch\TranslationManager\Controller@postDelete', [$group, $key]) ?>" class="delete-key <?= !$is_deleted ? "" : "hidden" ?>" data-method="POST"
                                        data-remote="true">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                            <?php endif; ?>
                            <td><?= $key ?></td>
                            <?php foreach($locales as $locale): ?>
                            <?php if (!array_key_exists($locale, $displayLocales)) continue; ?>
                            <?php $t = isset($translation[$locale]) ? $translation[$locale] : null ?>
                            <td <?= $locale === $translatingLocale ? 'class="auto-translatable"' : '' ?>>
                                <?= $translator->inPlaceEditLink(!$t ? $t : ($t->value == '' ? null : $t), true, "$group.$key", $locale, null, $group) ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">@lang('laravel-translation-manager::messages.search-translations')</h4>
                    </div>
                    <div class="modal-body">
                        <form id="search-form" method="GET" action="<?= $searchUrl ?>" data-remote="true">
                            <div class="form-group">
                                <div class="input-group">
                                    <input id="search-form-text" type="search" name="q" class="form-control"><span class="input-group-btn">
                                        <?= formSubmit(trans('laravel-translation-manager::messages.search'), ['class' => "btn btn-default"]) ?>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="results"></div>
                    </div>
                    <div class="modal-footer">
                        <?= ifEditTrans('laravel-translation-manager::messages.close') ?>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?= noEditTrans('laravel-translation-manager::messages.close') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- KeyOp Modal -->
        <div class="modal fade" id="keyOpModal" tabindex="-1" role="dialog" aria-labelledby="keyOpModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="keyOpModalLabel">@lang('laravel-translation-manager::messages.keyop-header')</h4>
                    </div>
                    <div class="modal-body">
                        <div class="results"></div>
                    </div>
                    <div class="modal-footer">
                        <?= ifEditTrans('laravel-translation-manager::messages.close') ?>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?= noEditTrans('laravel-translation-manager::messages.close') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('body-bottom')
    <!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
    <script>
        var CLIP_TEXT; // we store translation copy/paste here
        var YANDEX_TRANSLATOR_KEY = '{{isset($yandex_key) ? $yandex_key : ''}}';
        var PRIMARY_LOCALE = '{{$primaryLocale}}';
        var CURRENT_LOCALE = '{{$currentLocale}}';
        var TRANSLATING_LOCALE = '{{$translatingLocale}}';
        var xtranslateText;

        jQuery(document).ready(function ($) {
            $('.group-select').on('change', function () {
                window.location.href = '<?= action('Vsch\TranslationManager\Controller@getIndex') ?>/' + $(this).val();
            });

            $('a.delete-key').on('ajax:success', function (e, data) {
                var row = $(this).closest('tr');
                row.addClass("deleted-translation");

                $(this).addClass("hidden");
                row.find("a.undelete-key").first().removeClass("hidden");
            });

            $('a.undelete-key').on('ajax:success', function (e, data) {
                var row = $(this).closest('tr');
                row.removeClass("deleted-translation");

                $(this).addClass("hidden");
                row.find("a.delete-key").first().removeClass("hidden");
            });

            $('.form-import').on('ajax:success', function (e, data) {
                var elem = $('div.success-import-group');
                elem.html(elem.html().replace(/:count\b/, data.counter));
                elem.slideDown();
            });

            $('.form-import-all').on('ajax:success', function (e, data) {
                var elem = $('div.success-import-all');
                elem.html(elem.html().replace(/:count\b/, data.counter));
                elem.slideDown();
            });

            $('.form-find').on('ajax:success', function (e, data) {
                var elem = $('div.success-find');
                elem.html(elem.html().replace(/:count\b/, data.counter));
                elem.slideDown();
            });

            $('.form-publish-group').on('ajax:success', function (e, data) {
                $('div.success-publish').slideDown();
                $('tr.deleted-translation').remove();
            });

            $('.form-publish-all').on('ajax:success', function (e, data) {
                $('div.success-publish-all').slideDown();
                $('tr.deleted-translation').remove();
            });

            $('#form-keyops').on('ajax:success', function (e, data) {
                //                var elemModal = $('#keyOpModal').first();
                //                var elem = elemModal.find('.results');
                var elem = $('#wildcard-keyops-results').first();
                elem.html(data);
                //                elemModal.modal({show: true, keyboard: true/*, backdrop: 'static'*/});
                elem.find('.vsch_editable').vsch_editable();
            });

            var elemModal = $('#searchModal').first();
            elemModal.on('ajax:success', function (event, data, status, xhr) {
                var elem = elemModal.find('.results');
                elem.html(data);
                elem.find('.vsch_editable').vsch_editable();
            });

            $('#translate-current-primary').on('click', function () {
                var elemFrom = $('#current-text').first(),
                        fromText = elemFrom[0].value;
                xtranslateService(TRANSLATING_LOCALE, fromText, PRIMARY_LOCALE, function (text) {
                    var elem = $('#primary-text').first();
                    if (elem.length) {
                        elem.val(text);
                    }
                });
            });

            $('#translate-primary-current').on('click', function () {
                var elemFrom = $('#primary-text').first(),
                        fromText = elemFrom[0].value;
                xtranslateService(PRIMARY_LOCALE, fromText, TRANSLATING_LOCALE, function (text) {
                    var elem = $('#current-text').first();
                    if (elem.length) {
                        elem.val(text);
                    }
                });
            });

            $('#interface-locale').on('change', function () {
                $('#form-interface-locale')[0].submit();
            });

            $('#translating-locale').on('change', function () {
                $('#form-interface-locale')[0].submit();
            });

            $('#primary-locale').on('change', function () {
                $('#form-interface-locale')[0].submit();
            });

            $('#display-locale-all').on('click', function (e) {
                e.preventDefault();
                $('.display-locale').prop('checked',true);
            });

            $('#display-locale-none').on('click', function (e) {
                e.preventDefault();
                $('.display-locale').prop('checked',false);
            });

            var elemButton = $('#auto-translate');
            elemButton.on('click', function (e) {
                e.preventDefault();
                var autoTranslate = [], elemProgress = $('#auto-progress').first(), progTotal, progCurrent, btnText = elemButton.text(), btnAlt = elemButton.data('disable-with');

                // step through all the definitions in the second column and auto translate empty ones
                // here we make a log of assumptons about where the data is.
                // we assume that the source is the child element immediately preceeding this one and it is a <td> containing
                // <a> containing the source text
                $(".auto-translatable").each(function () {
                    var row = $(this).parent().find(".vsch_editable");
                    if (row.length > 1) {
                        var srcElem = $(row[0]),
                                dstElem = $(row[1]);

                        if (dstElem.length) {
                            if (dstElem.hasClass('editable-empty') && !srcElem.hasClass('editable-empty')) {
                                var dataName = dstElem.data('name'),
                                        dataUrl = dstElem.data('url'),
                                        srcText = srcElem.text();

                                autoTranslate.push({
                                    srcText: srcText,
                                    dataUrl: dataUrl,
                                    dataName: dataName,
                                    dstElem: dstElem
                                });
                            }
                        }
                    }
                });

                progTotal = autoTranslate.length;
                progCurrent = 0;

                // we could process all the keys in parallel but we will do it one at a time
                var fireTranslate, translateNext = function (t) {
                    xtranslateText(xtranslateService, PRIMARY_LOCALE, t.srcText, TRANSLATING_LOCALE, function (text, trans) {
                        if (text !== "") {

                            var jqxhr = $.ajax({
                                type: 'POST',
                                url: t.dataUrl,
                                data: {'name': t.dataName, 'value': text},
                                success: function (json) {
                                    if (json.status === 'ok') {
                                        // now can update the element and fire off the next translation
                                        t.dstElem.removeClass('editable-empty');
                                        t.dstElem.addClass('status-1');
                                        t.dstElem.text(text);
                                    }
                                    else {
                                        elemButton.removeAttr('disabled');
                                        elemButton.text(btnText);
                                    }
                                },
                                encode: true
                            });

                            jqxhr.done(function () {
                                fireTranslate();
                            });

                            jqxhr.fail(function () {
                                elemButton.removeAttr('disabled');
                                elemButton.text(btnText);
                            });
                        }
                        else {
                            elemButton.removeAttr('disabled');
                            elemButton.text(btnText);
                        }
                    });

                };

                fireTranslate = function () {
                    if (autoTranslate.length) {
                        progCurrent++;
                        translateNext(autoTranslate.pop());
                        elemButton.attr('disabled','disabled');
                        elemButton.text(btnAlt + ' ' + progCurrent + ' / ' + progTotal);
                    }
                    else {
                        elemButton.removeAttr('disabled');
                        elemButton.text(btnText);
                    }
                };

                // start the chain of translations
                for (i = 0; i < 4; i++) {
                    fireTranslate();
                }

            });

            function textareaTandemResize(src, dst, liveupdate) {
                return function () {
                    var srcTimeout = {id: null},
                            dstTimeout = {id: null};

                    // the handler function
                    var resizeEvent = function (src, dst, timeout) {
                        return function () {
                            if (dst.css("resize") === 'both') {
                                dst.outerWidth(src.outerWidth());
                                dst.outerHeight(src.outerHeight());
                            }
                            else {
                                if (dst.css("resize") === 'horizontal') {
                                    dst.outerWidth(src.outerWidth());
                                }
                                else {
                                    if (dst.css("resize") === 'vertical') {
                                        dst.outerHeight(src.outerHeight());
                                    }
                                }
                            }

                            if (timeout.id) {
                                clearTimeout(timeout.id);
                                timeout.id = null;
                            }
                        }
                    };

                    // This provides a "real-time" (actually 15 fps)
                    // event, while resizing.
                    // Unfortunately, mousedown is not fired on Chrome when
                    // clicking on the resize area, so the real-time effect
                    // does not work under Chrome.
                    if (liveupdate) {
                        $(window).on("mousemove", function (e) {
                            if (e.target === src[0]) {
                                if (srcTimeout.id) {
                                    clearTimeout(srcTimeout.id);
                                    srcTimeout.id = null;
                                }
                                srcTimeout.id = setTimeout(resizeEvent(src, dst, srcTimeout), 1000 / 30);
                            }
                            else {
                                if (e.target === dst[0]) {
                                    if (dstTimeout.id) {
                                        clearTimeout(dstTimeout.id);
                                        dstTimeout.id = null;
                                    }
                                    dstTimeout.id = setTimeout(resizeEvent(dst, src, dstTimeout), 1000 / 30);
                                }
                            }
                        });
                    }

                    // The mouseup event stops the interval,
                    // then call the resize event one last time.
                    // We listen for the whole window because in some cases,
                    // the mouse pointer may be on the outside of the textarea.
                    $(window).on("mouseup", function (e) {
                        if (srcTimeout.id !== null) {
                            clearTimeout(srcTimeout.id);
                            srcTimeout.id = null;
                        }
                        if (e.target === src[0]) {
                            resizeEvent(src, dst, srcTimeout)();
                        }
                        else {
                            if (e.target === dst[0]) {
                                resizeEvent(dst, src, dstTimeout)();
                            }
                        }
                    });
                };
            }

            var elem = $("#form-addkeys").first();
            textareaTandemResize(elem.find("textarea[name=keys]"), elem.find("textarea[name=suffixes]"), true)();
            textareaTandemResize($("#primary-text"), $("#current-text"), true)();
            textareaTandemResize($("#srckeys"), $("#dstkeys"), true)();
        });
    </script>
@stop

