import React from 'react';
import ReactDOM from "react-dom/client"
import Vkladki from './vkladki';
const  root=document.getElementById('vkladki')
if(root){
ReactDOM.createRoot(root).render(<Vkladki />)
}