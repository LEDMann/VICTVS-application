import React from 'react'
import ReactDOM from 'react-dom/client'
import { BrowserRouter, Route, Routes } from "react-router"
import './App.css'
import App from './App.jsx'
import Exams from './query/query.jsx'
import Navbar from './navbar.jsx'
import PageNotFound from './404.jsx'

ReactDOM.createRoot(document.getElementById('root')).render(
  <BrowserRouter>
    <div className='h-screen overflow-hidden'>
      <Navbar />
      <Routes>
        <Route path="/" element={<App />} />
        <Route path="exams" element={<Exams />} />
        <Route path="*" element={<PageNotFound />} />
      </Routes>
    </div>
  </BrowserRouter>
)
