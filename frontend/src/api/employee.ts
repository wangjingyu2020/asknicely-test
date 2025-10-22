import request from '../utils/request'
import type { Employee } from '../types/employee'

export const getEmployees = () =>
  request.get<Employee[]>('/api/employees')

export const uploadCsv = (formData: FormData) =>
  request.post('/api/upload', formData)

export const updateEmail = (name: string, email: string) =>
  request.put('/api/update-email', { name, email })

