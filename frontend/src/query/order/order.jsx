import { useContext, useState } from 'react'
import '../../App.css'
import { ErrorContext, OrderContext } from '../queryContext'
import OrderMenu from './orderMenu'

function Order() {
    const { order, setOrder } = useContext(OrderContext)
    const { setError } = useContext(ErrorContext)

    const invertOrder = () => {
        setError({"error": false, "message": ""})
        setOrder({"column": order.column, "order": !order.order})
    }

    return (
        <div className='flex flex-col p-2'>
            Order:
            <div className='flex flex-row w-full'>
                <OrderMenu />
                <button onClick={() => invertOrder()} className='basis-1/2 border-y-1 border-r-1 rounded-r-sm bg-slate-800 cursor-pointer hover:bg-slate-950 border-slate-600'>{ order.order ? "Ascending 🔽" : "Descending 🔼"}</button>
            </div>
        </div>
    )
}

export default Order