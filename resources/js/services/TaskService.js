import axios from 'axios';

const API_BASE_URL = '/api/tasks';

export default {
    /**
     * Busca todas as tarefas
     * @returns {Promise<Array>} Lista de tarefas
     */
    async getAll() {
        try {
            const response = await axios.get(API_BASE_URL);
            return response.data.data;
        } catch (error) {
            console.error('Erro ao buscar tarefas:', error);
            throw this.handleError(error);
        }
    },

    /**
     * Busca uma tarefa específica
     * @param {number} id - ID da tarefa
     * @returns {Promise<Object>} Dados da tarefa
     */
    async get(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/${id}`);
            return response.data.data;
        } catch (error) {
            console.error(`Erro ao buscar tarefa ${id}:`, error);
            throw this.handleError(error);
        }
    },

    /**
     * Cria uma nova tarefa
     * @param {Object} taskData - Dados da tarefa
     * @returns {Promise<Object>} Tarefa criada
     */
    async create(taskData) {
        try {
            const response = await axios.post(API_BASE_URL, taskData);
            return response.data.data;
        } catch (error) {
            console.error('Erro ao criar tarefa:', error);
            throw this.handleError(error);
        }
    },

    /**
     * Atualiza uma tarefa existente
     * @param {number} id - ID da tarefa
     * @param {Object} taskData - Dados atualizados
     * @returns {Promise<Object>} Tarefa atualizada
     */
    async update(id, taskData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/${id}`, taskData);
            return response.data.data;
        } catch (error) {
            console.error(`Erro ao atualizar tarefa ${id}:`, error);
            throw this.handleError(error);
        }
    },

    /**
     * Remove uma tarefa
     * @param {number} id - ID da tarefa
     * @returns {Promise<void>}
     */
    async delete(id) {
        try {
            await axios.delete(`${API_BASE_URL}/${id}`);
        } catch (error) {
            console.error(`Erro ao deletar tarefa ${id}:`, error);
            throw this.handleError(error);
        }
    },

    /**
     * Alterna o status de finalizado de uma tarefa
     * @param {number} id - ID da tarefa
     * @returns {Promise<Object>} Tarefa atualizada
     */
    async toggle(id) {
        try {
            const response = await axios.patch(`${API_BASE_URL}/${id}/toggle`);
            return response.data;
        } catch (error) {
            console.error(`Erro ao alternar status da tarefa ${id}:`, error);
            throw this.handleError(error);
        }
    },

    /**
     * Trata erros da API
     * @param {Error} error - Erro original
     * @returns {Error} Erro tratado
     */
    handleError(error) {
        if (error.response) {
            // Erro da API (4xx, 5xx)
            const message = error.response.data?.message || error.response.statusText;
            return new Error(message);
        } else if (error.request) {
            // Erro de conexão
            return new Error('Não foi possível conectar ao servidor');
        } else {
            // Outros erros
            return new Error('Ocorreu um erro inesperado');
        }
    }
};
