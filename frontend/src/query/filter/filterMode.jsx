import { useContext, useState } from 'react'
import '../../App.css'
import FilterModes from './filtermodes.json'
import { validateFilter } from './filterValidator'
import { ErrorContext, FilterContext } from '../queryContext'

function FilterMode() {
    const { filter, setFilter } = useContext(FilterContext)
    const { setError } = useContext(ErrorContext)

    const incrementFilterIndex = () => {
        setError({"error": false, "message": ""})
        var i = filter.mode.index+=1
        if (filter.mode.type == "shorttext") {
            setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": true, "mode": {"type": filter.mode.type, "index": (filter.mode.index >= FilterModes.shortTextModes.length ? 0 : i), "value": FilterModes.shortTextModes[(filter.mode.index >= FilterModes.shortTextModes.length ? 0 : i)]}, "value": filter.value })
        } else if (filter.mode.type == "longtext") {
            setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": true, "mode": {"type": filter.mode.type, "index": (filter.mode.index >= FilterModes.longTextModes.length ? 0 : i), "value": FilterModes.longTextModes[(filter.mode.index >= FilterModes.longTextModes.length ? 0 : i)]}, "value": filter.value })
        } else if (filter.mode.type == "integer") {
            setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": true, "mode": {"type": filter.mode.type, "index": (filter.mode.index >= FilterModes.integerModes.length ? 0 : i), "value": FilterModes.integerModes[(filter.mode.index >= FilterModes.integerModes.length ? 0 : i)]}, "value": filter.value })
        } else {
            setFilter({"column": "", "valid": validateFilter(filter), "enabled": true, "mode": {"type": "shorttext", "index": 0, "value": shortTextModes[0]}, "value": "" })
        }
        validateFilter(filter)
    }

    if (filter.column[0] != "") {
        return <button onClick={() => incrementFilterIndex()} className='basis-1/2 border-r-1 border-b-1 border-slate-600 rounded-br-sm bg-slate-800 cursor-pointer hover:bg-slate-950'>{ filter.mode.value[1] }</button>
    }
}

export default FilterMode