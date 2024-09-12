import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import Header from './assets/Header/Header.jsx'
import Output from './assets/Output/Output.jsx'
import Footer from './assets/Footer/Footer.jsx'
import Login from './assets/Login/Login.jsx'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <Header />
    {/* <Output /> */}
    {/* <Login/> */}
    <Footer />

  </StrictMode>,
)
