@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Редактировать профиль</div>
 
<form action='' method='POST' class="form">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div class="label">Имя</div>
            </div>
            <div class="col-sm-12">
                <input type='text' class="form-control" value="<?=Auth::user()->firstname?>" name="firstname">
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div class="label">Фамилия</div>
            </div>
            <div class="col-sm-12">
                <input type='text' class="form-control" value="<?=Auth::user()->lastname?>" name="lastname">
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div class="label">E-mail</div>
            </div>
            <div class="col-sm-12">
                <input type='text' class="form-control" value="<?=Auth::user()->email?>" disabled>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div class="label">Пол</div>
            </div>
            <div class="col-sm-12">
                <select name="gender" class="form-control">
                    <option value="0">Пол</option>
                    <option <?=Auth::user()->gender == 1? 'selected' : 'selected'?> value="1">Мужской</option>
                    <option <?=Auth::user()->gender == 2? 'selected' : 'selected'?> value="2">Женский</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div class="label">День Рождения</div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <select name="day" class="form-control">
                            <option value="0">День</option>
                            <?php for($i = 1; $i < 31; $i++){ ?>
                                <option <?=date('d',strtotime(Auth::user()->birthday)) == $i ? 'selected':''?> value="<?=$i?>"><?=$i?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="month" class="form-control">
                            <option value="0">Месяц</option>
                            <?php for($i = 1; $i <= 12; $i++){ ?>
                                <option <?=date('m',strtotime(Auth::user()->birthday)) == $i ? 'selected':''?> value="<?=$i?>"><?php //$this->config->monthes[$i]?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="year" class="form-control">
                            <option value="0">Год</option>
                            <?php for ($i = date('Y', time()) - 14; $i >= date('Y', time()) - 99; $i--) { ?>
                                <option value="<?= $i ?>"  <?=date('Y',strtotime(Auth::user()->birthday)) == $i ? 'selected':''?>><?=$i?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <input type='submit' value='Сохранить' class="btn btn-blue">
            </div>
        </div>
    </div>
    
</form>

@endsection