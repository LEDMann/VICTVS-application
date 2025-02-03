import { useContext, useState } from 'react'
import '../../App.css'
import { Field, Input, Label, Checkbox, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react'
import FilterToggle from './FilterToggle'
import FilterInput from './FilterInput'
import FilterMenu from './filterMenu'
import FilterMode from './filterMode'
import { FilterContext } from '../queryContext'

function Filter() {
  const filterContext = useContext(FilterContext)
  return (
      <div className={filterContext.filter.enabled ? 'flex flex-col border-b-1 border-slate-600 p-2 pt-1' : 'flex flex-col border-b-1 border-slate-600'}>
          <Field className="flex flex-col w-full">
            <FilterToggle />
            <FilterInput />
          </Field>
          { filterContext.filter.enabled &&
            <div className='flex flex-row w-full'>
              <FilterMenu />
              <FilterMode />
            </div>
          }
      </div>
  )
}

export default Filter