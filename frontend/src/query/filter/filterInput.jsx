import { useContext, useState } from 'react'
import '../../App.css'
import { validateFilter } from './filterValidator'
import { ErrorContext, FilterContext } from '../queryContext'
import { Input } from '@headlessui/react'

function FilterInput() {
    const { filter, setFilter } = useContext(FilterContext)
    const { setError } = useContext(ErrorContext)

    const updateFilter = (f) => {
        setError({"error": false, "message": ""})
        setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": true, "mode": filter.mode, "value": f.target.value })
        validateFilter(filter)
    }
    const updateFiltera = (a) => {
        setError({"error": false, "message": ""})
        setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": true, "mode": filter.mode, "value": [a.target.value, filter.value[1]] })
        validateFilter(filter)
    }
    const updateFilterb = (b) => {
        setError({"error": false, "message": ""})
        setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": true, "mode": filter.mode, "value": [filter.value[0], b.target.value] })
        validateFilter(filter)
    }

    if (filter.column[0] != "" && filter.enabled) {
        if (filter.mode.type == "integer" && filter.mode.index == 2) {
            return (
                <div className='flex flex-row'>
                    <Input name="filtera" type="text" className="shrink basis-1/2 min-w-0 border-1 rounded-tl-sm border-slate-600 p-2 px-3" onChange={updateFiltera} value={filter.value[0]} />
                    <Input name="filterb" type="text" className="shrink basis-1/2 min-w-0 border-y-1 border-r-1 rounded-tr-sm border-slate-600 p-2 px-3" onChange={updateFilterb} value={filter.value[1]} />
                </div>
            )
        } else {
            return <Input name="filter" type="text" className="border-1 rounded-t-sm border-slate-600 p-2 px-3" onChange={updateFilter} value={filter.value}/>
        }
    }
}

export default FilterInput