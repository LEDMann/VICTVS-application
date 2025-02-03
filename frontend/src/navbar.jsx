import './App.css'

function Navbar() {

  return (
    <div className='flex flex-row ml-4 gap-2'>
        <a className='px-2 py-1 bg-slate-800 hover:bg-slate-950 rounded-b-sm border-x-1 border-b-1 border-slate-600' href="/">Upload File</a>
        <a className='px-2 py-1 bg-slate-800 hover:bg-slate-950 rounded-b-sm border-x-1 border-b-1 border-slate-600' href="/exams">Query API</a>
    </div>
  )
}

export default Navbar