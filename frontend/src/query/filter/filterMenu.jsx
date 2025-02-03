import { useContext, useState } from 'react'
import '../../App.css'
import { validateFilter } from './filterValidator'
import FilterMenuButton from './filterMenuButton'
import FilterModes from './filtermodes.json'
import { ErrorContext, FilterContext } from '../queryContext'
import { Menu, MenuItem, MenuItems } from '@headlessui/react'

function FilterMenu() {
    const { filter, setFilter } = useContext(FilterContext)
    const { setError } = useContext(ErrorContext)

    const updateFilterColumn = (column) => {
        setError({"error": false, "message": ""})
        if (column == "title") {
            var index = (filter.mode.index >= 6) ? 0 : filter.mode.index
            setFilter({"column": ["title", "Title"], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "shorttext", "index": index, "value": FilterModes.shortTextModes[index]}, "value": "" })
        } else if (column == "description") {
            var index = (filter.mode.index >= 5) ? 0 : filter.mode.index
            setFilter({"column": ["description", "Description"], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "longtext", "index": index, "value": FilterModes.longTextModes[index]}, "value": "" })
        } else if (column == "titledescription") {
            var index = (filter.mode.index >= 5) ? 0 : filter.mode.index
            setFilter({"column": ["titledescription", "Title & Description"], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "longtext", "index": index, "value": FilterModes.longTextModes[index]}, "value": "" })
        } else if (column == "name") {
            var index = (filter.mode.index >= 6) ? 0 : filter.mode.index
            setFilter({"column": ["name", "Name"], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "shorttext", "index": index, "value": FilterModes.shortTextModes[index]}, "value": "" })
        } else if (column == "location") {
            var index = (filter.mode.index >= 6) ? 0 : filter.mode.index
            setFilter({"column": ["location", "Location"], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "shorttext", "index": index, "value": FilterModes.shortTextModes[index]}, "value": "" })
        } else if (column == "distance") {
            var index = (filter.mode.index >= 3) ? 0 : filter.mode.index
            setFilter({"column": ["distance", "Distance"], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "integer", "index": index, "value": FilterModes.integerModes[index]}, "value": "" })
        } else {
            setFilter({"column": ["", ""], "valid": validateFilter(filter), "enabled": true, "mode": {"type": "shorttext", "index": 0, "value": FilterModes.shortTextModes[0]}, "value": "" })
        }
        validateFilter(filter)
      }

    return (
        <Menu>
            <FilterMenuButton />
            <MenuItems anchor="bottom" className="rounded-b-sm bg-slate-800 cursor-pointer border-slate-600 border-x-1 border-b-1">
                <MenuItem>
                    <button onClick={() => updateFilterColumn("none")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        None
                    </button>
                </MenuItem>
                <MenuItem>
                    <button onClick={() => updateFilterColumn("title")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        Title
                    </button>
                </MenuItem>
                <MenuItem>
                    <button onClick={() => updateFilterColumn("description")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        Description
                    </button>
                </MenuItem>
                <MenuItem>
                    <button onClick={() => updateFilterColumn("titledescription")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        Title & Description
                    </button>
                </MenuItem>
                <MenuItem>
                    <button onClick={() => updateFilterColumn("name")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        Name
                    </button>
                </MenuItem>
                <MenuItem>
                    <button onClick={() => updateFilterColumn("location")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        Location
                    </button>
                </MenuItem>
                <MenuItem>
                    <button onClick={() => updateFilterColumn("distance")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                        Distance
                    </button>
                </MenuItem>
            </MenuItems>
        </Menu>
    )
}

export default FilterMenu