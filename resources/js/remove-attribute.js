function removeInputAttr(attrID, elementID){
    let mainAttr = attrID.replace('r-at-main-', '');
    let valAttr = attrID.replace('r-at-', '');
    if(isNaN(Number(mainAttr)) == false){ 
        removeAttribute('main', mainAttr, elementID);
    }
    if(isNaN(Number(valAttr)) == false){
        removeAttribute('value', valAttr, elementID);
    }       
}


function removeAttribute(attrType, attrID, elementID){
    $.ajax({
        url: "{{ route('admin.remove_attr') }}",
        type: 'POST',
        data: {
            attr_type: attrType,
            attr_id: attrID
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
            //elementData(event, elementID);
            let complexID = getComplexID(event, elementID); 
        }
    })
}
