import { useState } from 'react'
import './App.css'
import NotFound from './assets/404_not_found.gif'
import Welder from './assets/welder.gif'

function PageNotFound() {
  return (
    <div className='flex flex-col ml-4 gap-2 h-full justify-center'>
        <img src={NotFound} alt="404 Not Found" className='w-128 mx-auto'/>
        <img src={Welder} alt="welder gif" className='w-69 mx-auto mb-16'/>
    </div>
  )
}

export default PageNotFound