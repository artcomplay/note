<template>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <div class="input-create-element">
                                <input type="text" class="element-name form-control" name="element-name" placeholder="Название раздела">
                                <input type="submit" class="btn btn-success" data-dismiss="modal" aria-label="Close" onclick="createNote(event, null)" value="Создать раздел">
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
            console.log('8')
        }
    }
</script>