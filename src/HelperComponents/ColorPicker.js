import React, { useCallback, useRef, useState } from "react";
import { RgbaColorPicker } from "react-colorful";

import useClickOutside from "./useClickOutside";

function rgbatohex(color) {
    var r = color.r;
    var g = color.g;
    var b = color.b;
    var a = color.a;
    r = r.toString(16);
    g = g.toString(16);
    b = b.toString(16);
    a = Math.round(a * 255).toString(16);
  
    if (r.length == 1)
      r = "0" + r;
    if (g.length == 1)
      g = "0" + g;
    if (b.length == 1)
      b = "0" + b;
    if (a.length == 1)
      a = "0" + a;
    console.log("#" + r + g + b + a)
    return "#" + r + g + b + a;
  }


export const PopoverPicker = ({ color, onChange }) => {
    const popover = useRef();
    const [isOpen, toggle] = useState(false);

    const close = useCallback(() => toggle(false), []);
    useClickOutside(popover, close);
	let colour = `rgba(${color.r}, ${color.g}, ${color.b}, ${color.a})`;

    return (
        <div className="picker">
            <div
                className="swatch wpsf-color-box"
                style={{ backgroundColor: colour }}
                onClick={() => toggle(true)}
            >
                <div className="wpsf-color-value">{rgbatohex(color)}</div>
            </div>

            {isOpen && (
                <div className="popover" ref={popover}>
                    <RgbaColorPicker color={color} onChange={onChange} />
                </div>
            )}
        </div>
    );
};
