const MediaBox = ({ img, title, metaList }) => {
    return (
        <div className="exlac-vm-media">
            <img src={img} alt="" />
            <div className="exlac-vm-media__body">
                <h5 className="exlac-vm-media__title">{title}</h5>
                {/* <div className="exlac-vm-media__meta"> */}
                {
                    metaList.map((item, i) => {
                        return (
                            <span className="exlac-vm-media__meta" key={i}>
                                {
                                    item.type === "date" ? <span className="exlac-vm-media__meta--date">{item.text}</span> : ''
                                }
                                {
                                    item.type === "email" ? <span className="exlac-vm-media__meta--email">{item.text}</span> : ''
                                }
                                {
                                    item.type === "name" ? <span className="exlac-vm-media__meta--name">{item.text}</span> : ''
                                }
                            </span>

                        )

                    })
                }
                {/* </div> */}
            </div>
        </div>
    );
};

export default MediaBox;