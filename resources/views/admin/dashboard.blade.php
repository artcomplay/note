@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="row">
                <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <nav class="dash-vertical-menu">
                        <ul class="sections">
                            @foreach($sections as $section)
                                <li>
                                    <a class="section-href" href="" onclick="sectionData(event, '{{ $section->name }}', '{{ $section->id }}')">
                                        {{ $section->name }}
                                    </a>
                                    <i id="remove-section" class="fa fa-times" aria-hidden="true" onclick="removeSection(event, '{{ $section->name }}', '{{ $section->id }}')" title="Удалить раздел {{ $section->name }}"></i>
                                </li>
                            @endforeach

                            <li><a href="" onclick="appendInput(event)">+ Добавить раздел</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="main-block-section col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <body>
                        <div class="warning-block"></div>
                        <ul class="categories">
                            
                        </ul>
                    </body>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('custom_js')
<script>

    /*---- Section ----*/

    function sectionData(event, sectionName, idSection){
        event.preventDefault();
        console.log(idSection);
        $.ajax({
            url: "{{ route('admin.index') }}",
            type: 'GET',
            data: {
                sectionName: sectionName,
                sectionId: idSection
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    $('.categories').empty();
                    $('.warning-block').empty();
                    for(let i = 0; i < data.length; i++){
                        let categoryName = data[i].category_name;
                        let categoryId = data[i].id;
                        $('.categories').append('<li class="li-' + categoryId + '"><a href="" id="category-id-' + categoryId + '">' + categoryName + '</a><i id="remove-category" class="fa fa-times" aria-hidden="true" onclick="removeCategory(event, ' + categoryId +')" title="Удалить раздел ' + categoryName + '"></i> <i id="new-subject" class="fa fa-cube cat-id-' + categoryId + '" aria-hidden="true" onclick="appendInputSubject(' + categoryId + ')" title="Создать предмет"></i> <i id="new-attribute" class="fa fa-puzzle-piece ctg-id-' + categoryId + '" aria-hidden="true" onclick="appendInputAttribute(' + categoryId + ')" title="Создать атрибут"></i> </li><hr>');
                    }
                    $('.categories').append('<li><a href="" onclick="appendInputCategory(event, ' + idSection + ')">+ Добавить категорию</a></li>');
                } else{
                    $('.categories').empty();
                    $('.warning-block').empty();
                    $('.categories').append('<li class="alert alert-warning-section">Категории отсутствуют!</li><li><a href="" onclick="appendInputCategory(event, ' + idSection + ')">+ Добавить категорию</a></li>');
                }
            }
        })

    }

    function appendInput(event){
        event.preventDefault();
        let inputSection =$('.sections').children('input');
        if(inputSection.length == 0){
            $('.sections').append('<input class="form-control" placeholder="Название Раздела" id="input-section" type="text" name="section-name"/> <a href="" onclick="newSection(event)">Создать</a>');
        }
    }

    function appendInputCategory(event, idSecion){
        event.preventDefault();
        let inputSection =$('.categories').children('input');
        if(inputSection.length == 0){
            $('.categories').append('<input class="form-control" placeholder="Название Категории" id="input-category" type="text" name="section-name"/><a href="" onclick="newCategory(event, ' + idSecion + ')">Создать</a>');
        }
    }

    function newSection(event){
        event.preventDefault();
        let sN = $('#input-section').val();
        $.ajax({
            url: "{{ route('admin.create_section') }}",
            type: 'POST',
            data: {
                section: sN,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    let sName;
    let sId;

    function removeSectionSuccess(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.remove_section') }}",
            type: 'POST',
            data: {
                section: sName,
                sectionId: sId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    function removeSectionCancel(){
        $('.alert-warning-section').remove();
    }

    function removeSection(event, sectionName, sectionId){
        event.preventDefault();
        sName = sectionName;
        sId = sectionId;
        $('.warning-block').empty();
        $('.warning-block').prepend('<div class="alert alert-warning-section" role="alert">Раздел " ' + sectionName + ' " и все связанные с ним данные будут удалены!<button type="button" class="btn btn-success-section" onclick="removeSectionSuccess(event)">Удалить</button><button type="button" class="btn btn-warning-section" onclick="removeSectionCancel()">Отмена</button></div>');
    }

    /*---- Section ----*/



    /*---- Category ----*/

    let cName;
    let cId;

    function removeCategorySuccess(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.remove_category') }}",
            type: 'POST',
            data: {
                category_id: cId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    function removeCategoryCancel(){
        $('.alert-warning-section').remove();
    }

    function removeCategory(event, categoryId){
        event.preventDefault();
        let catName = $('#category-id-' + categoryId).html();
        cName = catName;
        cId = categoryId;
        $('.warning-block').empty();
        $('.warning-block').prepend('<div class="alert alert-warning-section" role="alert">Раздел " ' + catName + ' " и все связанные с ним данные будут удалены!<button type="button" class="btn btn-success-section" onclick="removeCategorySuccess(event)">Удалить</button><button type="button" class="btn btn-warning-section" onclick="removeCategoryCancel()">Отмена</button></div>');
    }

    function newCategory(event, idSection){
        event.preventDefault();
        let cat = $('#input-category').val();
        $.ajax({
            url: "{{ route('admin.create_category') }}",
            type: 'POST',
            data: {
                category: cat,
                idSection: idSection
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    /*---- Category ----*/



    /*---- Subject ----*/

    function appendInputSubject(categoryID){
        $('.input-div-' + categoryID).remove();
        $('.li-' + categoryID).append('<div class="input-div-' + categoryID + '"><input class="form-control input-subject" placeholder="Название Предмета" id="input-subject-'+ categoryID +'" type="text" name="section-name"/><a href="" onclick="newSubject(event, ' + categoryID + ')">Создать</a></div>');
    }

    /*---- Subject ----*/


    /*---- Element ----*/

    function appendInputElement(categoryID){
        console.log('Element ' + categoryID);
        /*<i id="new-element" class="fa fa-sun-o" aria-hidden="true" onclick="newElement()" title="Создать элемент"></i>*/

    }

    /*---- Element ----*/



    /*---- Attribute ----*/

    function appendInputAttribute(categoryID){
        $('.input-div-' + categoryID).remove();
        $('.li-' + categoryID).append('<div class="input-div-' + categoryID + '"><input class="form-control input-attribute" placeholder="Название Атрибута" id="input-attribute-'+ categoryID +'" type="text" name="section-name"/><a href="" onclick="newSubject(event, ' + categoryID + ')">Создать</a></div>');
    }

    /*---- Attribute ----*/

</script>

@endsection