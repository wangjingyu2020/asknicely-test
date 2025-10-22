import request from '../utils/request'

export interface CompanySalary {
  company_name: string
  avg_salary: number
}

export const getAverageSalary = () =>
  request.get<CompanySalary[]>('/api/average-salary')
