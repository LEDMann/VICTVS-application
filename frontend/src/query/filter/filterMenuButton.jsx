import { useContext, useState } from 'react'
import '../../App.css'
import { FilterContext } from '../queryContext'
import { MenuButton } from '@headlessui/react'

function FilterMenuButton() {
    const { filter } = useContext(FilterContext)
    if (filter.column[0] != "") {
        if (filter.enabled) {
            return <MenuButton className="grow bg-slate-800 cursor-pointer hover:bg-slate-950 border-b-1 border-x-1 rounded-bl-sm border-slate-600 py-2 px-4">{filter.column[0] != "" ? filter.column[1] : "select filter 🔽"}</MenuButton>
        } else {
            return <MenuButton className="grow bg-slate-800 cursor-pointer hover:bg-slate-950 border-x-1 border-b-1 rounded-b-sm border-slate-600 py-2 px-4">{filter.column[0] != "" ? filter.column[1] : "select filter 🔽"}</MenuButton>
        }
    } else {
        return <MenuButton className="grow bg-slate-800 cursor-pointer hover:bg-slate-950 border-1 rounded-sm border-slate-600 py-2 px-4">{filter.column[0] != "" ? filter.column[1] : "select filter 🔽"}</MenuButton>
    }
}

export default FilterMenuButton

