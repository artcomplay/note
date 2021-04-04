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

    function attributesData(event, categoryID){
        let attributesData;
        $.ajax({
            url: "{{ route('admin.attributes_data') }}",
            type: 'GET',
            data: {
                categoryID: categoryID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    attributesData = data;
                    
                    if(data.length != 0){
                        //console.log(attributesData);
                        for(let i = 0; i < attributesData.length; i++){
                            if(attributesData[i].attribute_name != null){
                                $('#attributes-row-' + categoryID).append('<li title="Дата создания атрибута ' + attributesData[i].created_at + '. Дата обновления атрибута ' + attributesData[i].updated_at + '">' + attributesData[i].attribute_name + '</li>');
                            }
                            if(attributesData[i].attribute_description != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_description + '</li>');
                            }
                            if(attributesData[i].attribute_double != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_double + '</li>');
                            }
                            if(attributesData[i].attribute_float != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_float + '</li>');
                            }
                            if(attributesData[i].attribute_int != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_int + '</li>');
                            }
                            if(attributesData[i].attribute_text != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_text + '</li>');
                            }
                            if(attributesData[i].attribute_time_first != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_time_first + '</li>');
                            }
                            if(attributesData[i].attribute_time_second != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_time_second + '</li>');
                            }
                            if(attributesData[i].attribute_varchar != null){
                                $('#attributes-row-' + categoryID).append('<li>' + attributesData[i].attribute_varchar + '</li>');
                            }
                            if(attributesData[i].created_at != null){
                                //$('#attributes-row-' + categoryID).append('<li>' + attributesData[i].created_at + '</li>');
                            }
                            if(attributesData[i].updated_at != null){
                                //$('#attributes-row-' + categoryID).append('<li>' + attributesData[i].updated_at + '</li>');
                            }
                            if(attributesData[i].attribute_bool != null && attributesData[i].attribute_bool == 1){
                                $('#attributes-row-' + categoryID).append('<li>Да</li>');
                            } else if(attributesData[i].attribute_bool != null && attributesData[i].attribute_bool == 0){
                                $('#attributes-row-' + categoryID).append('<li>Нет</li>');
                            }
                            $('#attributes-row-' + categoryID).append('<li style="width: 100%;"></li>');
                            
                        }
                    } else {
                        
                    }

                } else{
                    $('#attributes-row-' + categoryID).append('<li> Не содержится атрибутов </li>');
                }
            }
        })
    }

    function sectionData(event, sectionName, idSection){
        event.preventDefault();
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
                        $('.categories').append('<li id="li-' + categoryId + '"><a href="" onclick="categoryData(event, ' + categoryId + ')" id="category-id-' + categoryId + '">' + categoryName + '</a><i id="remove-category" class="fa fa-times" aria-hidden="true" onclick="removeCategory(event, ' + categoryId +')" title="Удалить раздел ' + categoryName + '"></i> <i id="new-subject" class="fa fa-cube cat-id-' + categoryId + '" aria-hidden="true" onclick="appendInputSubject(' + categoryId + ')" title="Создать предмет"></i> <i id="new-attribute" class="fa fa-puzzle-piece ctg-id-' + categoryId + '" aria-hidden="true" onclick="appendInputAttributeForCat(' + categoryId + ')" title="Создать атрибут"></i> <ul class="atr-st row" id="attributes-row-'+ categoryId +'"></ul> </li> <ul id="cat-' + categoryId + '"></ul><hr>');
                        attributesData(event, categoryId);
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



    function categoryData(event, categoryID){
        event.preventDefault();
        let child = $('#cat-' + categoryID).children();
        let disp = $('#cat-' + categoryID).css('display');
        console.log(child.length);
        if(child.length != 0 && disp == 'none'){
            $('#cat-' + categoryID).show();
        } else if(child.length != 0 && disp == 'block') {
            $('#cat-' + categoryID).hide();
        }

        $.ajax({
            url: "{{ route('admin.category_data') }}",
            type: 'GET',
            data: {
                categoryID: categoryID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                if(data.length != 0){
                    $('#cat-' + categoryID).empty();
                    $('.warning-block').empty();
                    for(let i = 0; i < data.length; i++){
                        let subjectName = data[i].subject_name;
                        let subjectId = data[i].id;
                        $('#cat-' + categoryID).append('<li class="sb-' + subjectId + '"><a href="" onclick="subjectData(event, ' + subjectId + ')" id="subject-id-' + subjectId + '">' + subjectName + '</a><i id="remove-subject" class="fa fa-times" aria-hidden="true" onclick="removeSubject(event, ' + subjectId +')" title="Удалить раздел ' + subjectName + '"></i> <i id="new-element" class="fa fa-sun-o" aria-hidden="true" onclick="newElement()" title="Создать элемент"></i> <i id="new-attribute" class="fa fa-puzzle-piece sbj-id-' + subjectId + '" aria-hidden="true" onclick="appendInputAttributeForSubject(' + subjectId + ')" title="Создать атрибут"></i> </li>');
                        $('#cat-' + categoryID).filter(':last');
                    }
                } else {
                    $('#cat-' + categoryID).empty();
                    $('#cat-' + categoryID).append('<li class="alert alert-warning-section">Предметы отсутствуют!</li>');
                }

                //console.log(data)
            }
        })
    }

    function appendInput(event){
        event.preventDefault();
        let inputSection =$('.sections').children('input');
        if(inputSection.length == 0){
            $('.sections').append('<input class="form-control" placeholder="Название Раздела" id="input-section" type="text" name="section-name"/> <a href="" class="create-button" onclick="newSection(event)">Создать</a>');
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
        $('#li-' + categoryID).append('<div class="input-div-' + categoryID + '"><input class="form-control input-subject" placeholder="Название Предмета" id="input-subject-'+ categoryID +'" type="text" name="section-name"/><a href="" onclick="newSubject(event, ' + categoryID + ')">Создать</a></div>');
    }

    function newSubject(event, categoryID){
        event.preventDefault();
        let subj = $('#input-subject-' + categoryID).val();
        $.ajax({
            url: "{{ route('admin.create_subject') }}",
            type: 'POST',
            data: {
                subject: subj,
                categoryID: categoryID
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    /*---- Subject ----*/


    /*---- Element ----*/

    function appendInputElement(categoryID){
        //console.log('Element ' + categoryID);
        /*<i id="new-element" class="fa fa-sun-o" aria-hidden="true" onclick="newElement()" title="Создать элемент"></i>*/

    }

    /*---- Element ----*/



    /*---- Attribute ----*/

    function appendInputAttributeForCat(categoryID){
        $('.input-div-' + categoryID).remove();
        $('#li-' + categoryID).append('<div class="input-div-' + categoryID + '"><form id="category-form-' + categoryID + '"><input class="form-control input-attribute" placeholder="Название Атрибута" id="" type="text" name="attribute-name"/> <input class="form-control input-attribute" placeholder="Описание Атрибута" id="" type="text" name="description"/> <input class="form-control input-attribute" placeholder="Номинальное значение Атрибута (Целое число)" id="" type="number" name="number-attribute"/> <input class="form-control input-attribute" placeholder="Номинальное значение Атрибута (Дробное число - точность 2 после запятой)" id="" type="number" name="double-2"/> <input class="form-control input-attribute" placeholder="Номинальное значение Атрибута (Дробное число - точность 15 после запятой)" id="" type="number" name="double-15"/> <span class="span-attribute">Время начала</span> <input class="form-control input-attribute" placeholder="Время" id="" type="time" name="time-first"/> <span class="span-attribute">Время окончания</span> <input class="form-control input-attribute" placeholder="Время" id="" type="time" name="time-second"/> <input class="form-control input-attribute" placeholder="Текст Атрибута" id="" type="text" name="attribute-text"/> <input class="form-control input-attribute" placeholder="Строковые данные" id="" type="text" name="attribute-varchar"/> <input class="form-control input-attribute file-input" id="" type="file" name="attribute-file"/> <span class="span-attribute">Да</span> <input class="form-control input-attribute input-radio-attribute" id="" type="radio" name="attribute-bool" value="true" /> <span class="span-attribute">Нет</span> <input class="form-control input-attribute input-radio-attribute" id="" type="radio" name="attribute-bool" value="false"/> <input class="form-control input-attribute" placeholder="IP адрес" id="" type="text" name="attribute-ip"/> <input type="submit" class="create-button"  onclick="newAttributeForCat(event, ' + categoryID + ')"/></form> <hr style="width: 25%;"></div>');
    }

    function newAttributeForCat(event, categoryID){
        event.preventDefault();
        let subj = $('#category-form-' + categoryID).children('input');
        let createAttribute = 'category';
        $.ajax({
            url: "{{ route('admin.create_attribute') }}",
            type: 'POST',
            data: {
                attributeName: subj[0].value,
                description: subj[1].value,
                numberAttribute: subj[2].value,
                double2: subj[3].value,
                double15: subj[4].value,
                timeFirst: subj[5].value,
                timeSecond: subj[6].value,
                attributeText: subj[7].value,
                attributeVarchar: subj[8].value,
                attributeFile: subj[9].value,
                attributeTrue: subj[10].checked,
                attributeFalse: subj[11].checked,
                attributeIP: subj[12].value,
                createAttribute: createAttribute,
                categoryID: categoryID

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                location.reload()
            }
        })
    }

    /*---- Attribute ----*/

</script>

@endsection