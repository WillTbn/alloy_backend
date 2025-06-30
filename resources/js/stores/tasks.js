import { defineStore } from 'pinia';
import { ref } from 'vue';
import TaskService from '../services/TaskService';

export const useTaskStore = defineStore('tasks', {

    state: () => ({
        tasks: [],
        loading: false,
        error: null,
        modelCreate:false,
        task:null
    }),
    actions: {

        async fetchTasks() {
            try {
                this.loading = true;
                this.tasks = await TaskService.getAll();
                this.error = null;
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },

        async createTask(taskData) {
            try {
                this.loading = true;
                const newTask = await TaskService.create(taskData);
                this.tasks.unshift(newTask);
                this.error = null;
                return newTask;
            } catch (err) {
                this.error = err.message;
                throw err;
            } finally {
                this.loading = false;
            }
        },

        async  updateTask(id, taskData) {
            try {
                this.loading = true;
                const updatedTask = await TaskService.update(id, taskData);
                const index = this.tasks.findIndex(t => t.id === id);
                if (index !== -1) {
                    this.tasks[index] = updatedTask;
                }
                this.error.value = null;
                return updatedTask;
            } catch (err) {
               this.error = err.message;
                throw err;
            } finally {
                this.loading = false;
            }
        },

        async deleteTask (id) {
            try {
                this.loading = true;
                await TaskService.delete(id);
                this.tasks = this.tasks.filter(t => t.id !== id);
                this.error = null;
            } catch (err) {
                this.error = err.message;
                throw err;
            } finally {
                this.loading = false;
            }
        },

        async toggleTask (id) {
            try {
                this.loading = true;
                const updatedTask = await TaskService.toggle(id);
                const index = this.tasks.findIndex(t => t.id === id);
                if (index !== -1) {
                   this.tasks[index] = updatedTask;
                }
                this.error = null;
                return updatedTask;
            } catch (err) {
                this.error = err.message;
                throw err;
            } finally {
                this.loading = false;
            }
        },


        setModelCreate(value) {
            this.modelCreate = value;
        },
        setError(value) {
            this.error = value;
        },
        setTask(value) {
            this.task = value;
        }
    }
});
