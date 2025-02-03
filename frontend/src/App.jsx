import { useState } from 'react'
import './App.css'

function App() {
  const [file, setFile] = useState(null);
  const [done, setDone] = useState(false);
  const [error, setError] = useState({"error": false, "message": ""});

  const handleFileChange = (e) => {
    if (e.target.files) {
      setError({"error": false, "message": ""})
      setFile(e.target.files[0]);
    }
  };
  const handleUpload = async (e) => {
    if (file) {
      const formData = new FormData();
      formData.append('file', file);
      try {
        const result = await fetch(import.meta.env.VITE_SERVER_URL + 'upload.php', { method: 'POST', body: formData, credentials: 'include' });
        const data = await result.json();
        if (Object.keys(data)[0] == "success") {
          console.log("success", data.success);
          setDone(true)
        } else {
          console.log("error", data.error)
          setError({"error": true, "message": data.error})
        }
      } catch (error) {
        console.error("error", error);
      }
    }
  }
  return (
    <>
    <div className='flex h-screen'>
      <div className="flex flex-col border-1 border-slate-600 rounded-sm m-auto">
        <div className="input-group border-b-1 border-slate-600 text-left px-4 py-2">
          Upload JSON file:
        </div>
        <div className="input-group bg-slate-800 hover:bg-slate-950 rounded-sm border-1 border-slate-600 px-8 m-2">
          <input className="cursor-pointer" id="file" type="file" onChange={handleFileChange} />
        </div>

        {file && (
          <div className="border-y-1 border-slate-600 px-16 py-4">
            <p className="border-b-1 border-slate-600 text-left">File details:</p>
            <ul>
              <li className="text-left">Name: {file.name}</li>
              <li className="text-left">Type: {file.type}</li>
              <li className="text-left">Size: {file.size} bytes</li>
            </ul>
          </div>
        )}
        { error.error ? <p className='m-2 text-center grow bg-red-800 border-1 rounded-sm border-red-600'>{error.message} - select new file to reset</p> : file ? ( done ? (<a href="/exams" className="m-2 text-center grow bg-slate-800 hover:bg-slate-950 border-1 rounded-sm border-slate-600">View Exams ▶</a>) : (<button onClick={handleUpload} className="cursor-pointer m-2 grow bg-slate-800 hover:bg-slate-950 border-1 rounded-sm border-slate-600">Upload a file</button>) ) : (<div></div>) }
      </div>
    </div>
    </>
  )
}

export default App
