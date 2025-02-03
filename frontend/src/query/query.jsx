import { useState } from 'react'
import '../App.css'
import { ErrorContext, ExamContext, FilterContext, OrderContext } from './queryContext'
import Exam from './exams/exam';
import Filter from './filter/filter';
import Order from './order/order';

function Exams() {
  const [exams, setExams] = useState()
  const [coords, setCoords] = useState({ "lat": 0, "long": 0 })
  const [filter, setFilter] = useState({column: ["", ""], valid: false, enabled: false, mode: {type: "shorttext", index: 0, value: ["", ""]}, value: "" })
  const filterValue = {filter, setFilter}
  const [order, setOrder] = useState({column: ["date", "Date"], order: true})
  const orderValue = {order, setOrder}
  const [error, setError] = useState({error: false, message: ""})
  const errorValue = {error, setError}

  const getLocation = () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (p) => setCoords({ "lat": p.coords.latitude, "long": p.coords.longitude }),
        (e) => console.log(`error retrieving coordinates - ${{ e }}`)
      )
    } else {
      console.error("geolocation unsupported")
    }
  }

  getLocation()

  const getExams = async () => {
    console.log("filter obj: ", filter)
    try {
      const result = await fetch(
        `${import.meta.env.VITE_SERVER_URL}exams/api.php?` + 
        `${(coords.lat != 0 && coords.long != 0) ? `lat=${coords.lat}&long=${coords.long}` : ``}` + 
        `${filter.enabled ? `&filterby=${filter.column[0]}&filtermode=${filter.mode.value[0]}&filter=${(filter.mode.type == 'integer' && filter.mode.index == 2) ? `${filter.value[0]}.${filter.value[1]}` : filter.value}` : ``}` +
        `${(order.column[0] != "") ? `&orderby=${order.column[0]}&dir=${order.order ? 'asc' : 'desc'}` : ``}`, {
        method: 'GET',
        credentials: 'include',
      });

      const data = await result.json();

      if (data.error) {
        setError({"error": true, "message": data.error_message})
      } else {
        setError({"error": false, "message": ""})
        setExams(data.exams.map((e) => (Exam(e))))
        console.log(exams)
      }
    } catch (error) {
      console.error("error", error);
    }
  }

  return (
    <div className='flex flex-col gap-4 h-full m-auto'>
      <div className='m-auto flex flex-col border-1 rounded-sm border-slate-600 w-96'>
        <h1 className='text-xl p-2 border-b-1 border-slate-600'>get exams from api</h1>
        <div className='flex flex-col border-b-1 border-slate-600'>
          <ErrorContext.Provider value={errorValue}>
            <FilterContext.Provider value={filterValue}>
              <Filter />
            </FilterContext.Provider>
            <OrderContext.Provider value={orderValue}>
              <Order />
            </OrderContext.Provider>
          </ErrorContext.Provider>
        </div>
        { error.error ? 
          <p className='m-2 text-center grow bg-red-800 border-1 rounded-sm border-red-600'>{error.message} - update query options to reset</p> : 
          <button onClick={getExams} className='bg-slate-800 cursor-pointer m-2 rounded-sm border-1 border-slate-600 hover:bg-slate-950'>submit</button>
        }
      </div>
      { exams && 
          <>
            <div className='m-auto p-4 border-1 border-slate-600 rounded-sm w-128'>
              <ul className='flex flex-col gap-4 pr-4 h-96 overflow-y-auto w-full'>
                {exams}
              </ul>
            </div>
          </>
        }
    </div>
  )
}

export default Exams
