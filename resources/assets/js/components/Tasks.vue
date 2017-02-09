<template>
    <div>
        <form action="#" @submit.prevent="isEdit ? update(task.id) : create()">
            <div class="input-group">
                <input type="text" v-model="task.content" ref="taskinput" class="form-control" name="content" placeholder="I have to...">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
        <hr>
        <ul class="list-group">
            <li class="list-group-item" v-for="task in list">
                {{ task.content }}
                <button v-on:click="edit(task.id)" class="btn btn-primary btn-xs">Edit</button>
                <button v-on:click="deleteTask(task.id)" class="btn btn-warning btn-xs">Delete</button>
             </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                isEdit: false,
                list: [],
                task: {
                    id: '',
                    content: ''
                }
            };
        },

        mounted: function() {
            this.fetch();
        },

        methods: {
            fetch: function() {
                var tasks = this;
                window.axios.get('api/task').then(function (response) {
                    tasks.list = response.data
                });
            },

            create: function () {
                var cmp = this;
                window.axios.post('api/task/store', {
                    content: this.task.content
                }).then(function(response){
                    cmp.task.content = ''
                    cmp.isEdit = false
                    cmp.fetch()
                })
            },

            update: function(id) {
                var cmp = this;
                window.axios.patch('api/task/' + id, {
                    content: this.task.content
                }).then(function(response){
                    cmp.task.content = ''
                    cmp.isEdit = false
                    cmp.fetch()
                })
            },

            edit: function(id) {
                var cmp = this;
                window.axios.get('api/task/' + id).then(function(response) {
                    cmp.task.id = response.data.id
                    cmp.task.content = response.data.content
                    cmp.$refs.taskinput.focus()
                    cmp.isEdit = true
                })
            },

            deleteTask: function (id) {
                var cmp = this;
                window.axios.delete('api/task/' + id).then(function(response){
                    cmp.fetch()
                })
            },
        }
    }
</script>