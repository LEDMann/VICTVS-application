import { useContext, useState } from 'react'
import '../../App.css'
import { ErrorContext, OrderContext } from '../queryContext'
import { Menu, MenuItem, MenuItems, MenuButton } from '@headlessui/react'

function OrderMenu() {
    const { order, setOrder } = useContext(OrderContext)
    const { setError } = useContext(ErrorContext)

    const updateOrderColumn = (column) => {
        setError({"error": false, "message": ""})
        if (column == "title") {
            setOrder({"column": ["title", "Title"], "order": order.order})
        } else if (column == "name") {
            setOrder({"column": ["name", "Name"], "order": order.order})
        } else if (column == "id") {
            setOrder({"column": ["id", "User ID"], "order": order.order})
        } else if (column == "distance") {
            setOrder({"column": ["distance", "Distance"], "order": order.order})
        } else { // defaults to date
            setOrder({"column": ["date", "Date"], "order": order.order})
        }
    }
    return (
        <Menu>
            <MenuButton className="grow bg-slate-800 cursor-pointer hover:bg-slate-950 border-1 rounded-l-sm border-slate-600 px-4 py-2">{ order.column[1] }</MenuButton>
            <MenuItems anchor="bottom" className="rounded-b-sm bg-slate-800 cursor-pointer border-slate-600 border-x-1 border-b-1">
            <MenuItem>
                <button onClick={() => updateOrderColumn("date")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                    Date
                </button>
            </MenuItem>
            <MenuItem>
                <button onClick={() => updateOrderColumn("title")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                    Title
                </button>
            </MenuItem>
            <MenuItem>
                <button onClick={() => updateOrderColumn("name")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                    Name
                </button>
            </MenuItem>
            <MenuItem>
                <button onClick={() => updateOrderColumn("id")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                    User ID
                </button>
            </MenuItem>
            <MenuItem>
                <button onClick={() => updateOrderColumn("distance")} className="block w-full cursor-pointer text-left hover:bg-slate-950 p-2">
                    Distance
                </button>
            </MenuItem>
            </MenuItems>
        </Menu>
    )
}

export default OrderMenu