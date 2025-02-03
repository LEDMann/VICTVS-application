import { useContext, useState } from 'react'
import '../../App.css'
import { Label, Checkbox } from '@headlessui/react'
import { CheckIcon } from '@heroicons/react/16/solid'
import { validateFilter } from './filterValidator'
import { ErrorContext, FilterContext } from '../queryContext'

function FilterToggle() {
    const { filter, setFilter } = useContext(FilterContext)
    const { setError } = useContext(ErrorContext)

    const toggleEnableFilter = () => {
        setError({"error": false, "message": ""})
        setFilter({"column": filter.column, "valid": validateFilter(filter), "enabled": !filter.enabled, "mode": filter.mode, "value": filter.value })
      }

    return (
        <div className={filter.enabled ? 'flex flex-row gap-2 my-2' : 'flex flex-row gap-2 m-2' }>
            <Label>{filter.enabled ? "Disable Filtering" : "Enable Filtering"}:</Label>
            <Checkbox checked={filter.enabled} onChange={() => toggleEnableFilter()} className="group size-6 rounded-md bg-white/10 p-1 ring-1 ring-white/15 ring-inset data-[checked]:bg-white">
                <CheckIcon className="hidden size-4 fill-black group-data-[checked]:block" />
            </Checkbox>
        </div>
    )
}

export default FilterToggle