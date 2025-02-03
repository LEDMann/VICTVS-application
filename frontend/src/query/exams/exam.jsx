import '../../App.css'

function Exam(exam) {
  return (
    <li key={exam.id} className="flex flex-col border-1 border-slate-600 p-0 rounded-sm w-full">
      <div className="flex flex-row border-b-1 border-b-slate-600">
        <p className="grow text-left mx-2">{exam.Title}</p>
        <p className="mx-2">{exam.Date}</p>
      </div>
      <div className="flex flex-row border-b-1 border-b-slate-600">
        <div className="grow border-e-1 border-e-slate-600">
          <p className="mx-2 text-left">{exam.Description}</p>
        </div>
        <div className="flex flex-row">
          <p className="mx-2">{exam.CandidateName}</p>
          <p className="mx-2">{exam.Candidateid}</p>
        </div>
      </div>
      <div className="flex flex-col">
        <p className="mx-2">location: {exam.LocationName}</p>
        { exam.Distance > 0 &&
          <p className="mx-2 grow text-left">distance: {exam.DistanceFormatted}Km</p>
        }
      </div>
    </li>
  )
}

export default Exam