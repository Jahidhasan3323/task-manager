<script setup>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import {ref} from "vue";
import ApiService from "@/apiClient.js";

const data = ref({});
const isEdit = ref(false);
const selectedId = ref();
const form = ref({
    title: '',
    sort_description: '',
});
const errors = ref();

const getResults = (page = 1) => {
    ApiService.get(`/tasks?page=${page}`, {
        page: page
    })
        .then(response => {
            data.value = response.data.data;
        })
        .catch((error) => {
            const res = error.response.data;
            Toast.fire({icon: 'error', title: res.error })
        })
}

getResults();

const createTask = () => {
    const url = isEdit ? `/tasks/${selectedId.value}` : '/tasks';
    const method = isEdit ? 'update' : 'post';
    ApiService[method](url, form.value)
        .then(response => {
            Toast.fire({icon: 'success', title: response.data.message })
            errors.value=null
            form.value = {
                title: '',
                sort_description: ''
            }
            const myModal = document.getElementById('closeTaskModal');
            myModal.click();
            getResults();
        })
        .catch((error) => {
            const res = error.response.data;
            if (error.response.status === 422) {
                errors.value = res.errors
            } else {
                errors.value=null
                Toast.fire({icon: 'error', title: res.data.error })
            }
        })
}

const deleteTask = (id) => {
    ApiService.delete(`/tasks/${id}`)
        .then(response => {
            Toast.fire({icon: 'success', title: response.data.message })
            getResults();
        })
        .catch((error) => {
            const res = error.response.data;
            Toast.fire({icon: 'error', title: res.message })
        })
}

const updateStatus = (id, status) => {
    ApiService.get(`/update-status/${id}?status=${status}`)
        .then(response => {
            Toast.fire({icon: 'success', title: response.data.message })
            getResults();
        })
        .catch((error) => {
            Toast.fire({icon: 'error', title: error.response?.data?.message })
        })
}

const editTask = (id) => {
    ApiService.get(`/tasks/${id}`)
        .then(response => {
            const res = response.data.data;
            if (res) {
                isEdit.value = true;
                selectedId.value = res?.id;
                form.value.title = res?.title;
                form.value.sort_description = res?.sort_description;
                const myModal = document.getElementById('creatTaskBtn');
                myModal.click();
            }
        })
        .catch((error) => {
            Toast.fire({icon: 'error', title: error.response?.data?.message });
        })
}
</script>

<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-body-secondary">
                    Task List
                    <button id="creatTaskBtn" class="btn btn-primary btn-sm float-end"  title="Create Task" type="button" data-bs-toggle="modal" data-bs-target="#taskModal">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Sort Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in data.data"
                            :class="item.status === 'incomplete' ? 'text-decoration-line-through' : ''"
                        >
                            <th>{{index+1}}</th>
                            <td>{{ item.title }}</td>
                            <td>{{ item.sort_description }}</td>
                            <td>{{ item.status }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" title="Edit Task" @click="editTask(item.id)"><i class="fa-solid fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm ms-2" title="Delete Task" @click="deleteTask(item.id)"><i class="fa-solid fa-trash"></i></button>
                                <button v-if="item.status === 'incomplete'" type="button" title="Mark Incomplete" class="btn btn-warning btn-sm ms-2"  @click="updateStatus(item.id, 'complete')">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                                <button v-else type="button" class="btn btn-success btn-sm ms-2" title="Mark Complete"  @click="updateStatus(item.id, 'incomplete')">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Bootstrap5Pagination
                        :data="data"
                        @pagination-change-page="getResults"
                        align="right"
                    />
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createTaskLabel">Create Task</h1>
                        <button type="button" id="closeTaskModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createTask">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Title" v-model="form.title">
                                <span v-if="errors?.title" class="text-danger" v-for="error in errors.title">{{error}}</span>

                            </div>
                            <div class="mb-3">
                                <label for="sort_description" class="form-label">Sort Description</label>
                                <input type="text" class="form-control" id="sort_description" placeholder="Sort Description" v-model="form.sort_description">
                                <span v-if="errors?.sort_description" class="text-danger" v-for="error in errors.sort_description">{{error}}</span>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
