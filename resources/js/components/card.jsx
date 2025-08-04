import React from "react";
 export default class Card extends React.Component{
    render(){
        const {book} =this.props;
        return(
            <div className="mt-5  h-[35dvh] prs ">
            <div className="product-card">
                <a href={`/book#${book.id}`}>
                <img src={book.img} alt="Товар" className="product-image" />
                <div className="product-info">
                    <h5 className="mt-[20%]">{book.name}</h5>
                    <p>{book.copyright_holder}</p>
                </div>
                </a>
       
            </div>
            <div>
            <p className="text-[#9370DB] text-[18px] ">{book.price} руб.</p>
            </div>
    </div> 
        )
    }
}