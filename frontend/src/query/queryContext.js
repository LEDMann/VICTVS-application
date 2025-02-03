import { createContext } from "react";

export const FilterContext = createContext({
    Filter: {
        column: ["", ""], 
        valid: false, 
        enabled: false, 
        mode: {
            type: "shorttext", 
            index: 0, 
            value: ["", ""]
        }, 
        value: "" 
    }, 
    setFilter: () => {}
})


export const OrderContext = createContext({
    Order: {
        column: ["date", "Date"], 
        order: true
    }, 
    setOrder: () => {}
})


export const ErrorContext = createContext({
    Error: {
        error: false, 
        message: ""
    }, 
    setError: () => {}
})


export const ExamContext = createContext({
    exams: [],
    setExams: () => {}
})

