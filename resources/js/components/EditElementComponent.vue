<template>
    <div class="modal fade bd-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <div class="input-create-element">
                                <input type="text" class="element-edit-name form-control" name="element-name" placeholder="Новое название элемента">
                                <input type="submit" class="btn btn-success edit-element" data-dismiss="modal" aria-label="Close" onclick="editElement(event, id)" value="Изменить">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('6')
        }
    }
</script>